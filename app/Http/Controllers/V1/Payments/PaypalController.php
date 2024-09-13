<?php
namespace App\Http\Controllers\V1\Payments;
use App\Enum\PaymentSystemEnum;
use App\Events\OrderCreatedEvent;
use App\Events\Admin\AdminOrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Resources\V1\Orders\OrderResource;
use App\Repositories\Contract\CartRepositoryContract;
use App\Repositories\Contract\OrderRepositoryContract;
use App\Services\Contracts\PayPalServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaypalController extends Controller
{

    public function __construct(public PayPalServiceContract $payPalService,public  OrderRepositoryContract $orderRepository,public CartRepositoryContract $cartRepository)
    {

    }

    public function create(CreateOrderRequest $request): \Illuminate\Http\JsonResponse|OrderResource
    {
        try {
            DB::beginTransaction();

            $cartItems = Auth::check() ? Auth::user()->cartItems()->with(['product'])->get() :
                $this->cartRepository->convertCartItemsToCollection($request['cartItems']);

            $subTotal = $this->cartRepository->getSubTotal($cartItems);
            $paypalOrderId  = $this->payPalService->create($cartItems);
            $data = [
                ...$request->validated(),
                'vendor_order_id'=>$paypalOrderId,
                'total'=>$subTotal
            ];
            if (!$paypalOrderId) {
                return response()->json('Payment was not completed', 500);
            }
            $order = $this->orderRepository->create($data);
            DB::commit();
            return new OrderResource($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->info($exception->getMessage());
            logs()->error($exception->getMessage());
            return response()->json('Error', 500);
        }
    }

    public function capture($vendorOrderId): \Illuminate\Http\JsonResponse|OrderResource
    {
        try {
            DB::beginTransaction();
            $paymentStatus = $this->payPalService->capture($vendorOrderId);
            $order = $this->orderRepository->setTransaction($vendorOrderId,PaymentSystemEnum::PAY_PAL,$paymentStatus );
            //clear cart for user
            if(Auth::check()){
                Auth::user()->cartItems()->delete();
            }
            DB::commit();
            OrderCreatedEvent::dispatchIf($order, $order);
            AdminOrderCreatedEvent::dispatch($order->total);
            return new OrderResource($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json('Error', 500);
        }
    }
}
