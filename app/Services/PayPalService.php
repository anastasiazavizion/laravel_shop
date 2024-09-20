<?php
namespace App\Services;

use App\Enum\TransactionStatus;
use App\Repositories\Contract\CartRepositoryContract;
use App\Services\Contracts\PayPalServiceContract;
use Illuminate\Support\Collection;
use Srmklive\PayPal\Services\PayPal;

class PayPalService implements PayPalServiceContract
{
    protected Paypal $payPalClient;

    public function __construct()
    {
        $this->payPalClient = app(PayPal::class);
        $this->payPalClient->setApiCredentials(config('paypal'));
        $this->payPalClient->setAccessToken($this->payPalClient->getAccessToken());
    }

    public function create(Collection|array $cartItems): string|null
    {
        $paypalOrder = $this->payPalClient->createOrder($this->buildOrderRequestData($cartItems));
        return $paypalOrder['id'] ?? null;
    }

    public function capture(string $vendorOrderId): TransactionStatus
    {
        $result = $this->payPalClient->capturePaymentOrder($vendorOrderId);

        return match($result['status']) {
            'COMPLETED', 'APPROVED' => TransactionStatus::SUCCESS,
            'CREATED', 'SAVED' => TransactionStatus::PENDING,
            default => TransactionStatus::CANCELLED
        };
    }

    public function buildOrderRequestData(Collection $cartItems) : array
    {
        $currencyCode = config('paypal.currency');
        $items = [];

        $cartRepository = app(CartRepositoryContract::class);
        $subTotal = $cartRepository->getSubTotal($cartItems);

        $cartItems->each(function ($item) use ($currencyCode, &$items) {
            $items[] = [
                'name'=>$item->product->title,
                'quantity'=>$item->amount,
                'sku'=>$item->product->SKU,
                'url'=> url('/products/'.$item->product->id),
                'category'=>config('paypal.category'),
                'unit_amount'=>[
                    'value'=>$item->product->price,
                    'currency_code'=>$currencyCode,
                ],
                'tax'=>[
                    'value'=> 0,
                    'currency_code'=>$currencyCode,
                ]
            ];
        });

      return  [
          'intent'=>'CAPTURE',
          'purchase_units'=>[
              [
                  'amount'=>[
                      'currency_code'=>$currencyCode,
                      'value'=>$subTotal,
                      'breakdown'=>[
                          'item_total'=>[
                              'currency_code'=>$currencyCode,
                              'value'=>$subTotal
                          ],
                          'tax_total'=>[
                              'currency_code'=>$currencyCode,
                              'value'=>0
                          ]
                      ]
                  ],
                  'items'=>$items
              ]

          ]
      ];
    }
}
