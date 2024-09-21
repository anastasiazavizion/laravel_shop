<?php
namespace App\Services;
use App\Models\Order;
use App\Services\Contracts\InvoiceServiceContract;
use LaravelDaily\Invoices\Invoice;

use App\Enum\OrderStatusEnum;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Facades\Invoice as Facade;

class InvoiceService implements InvoiceServiceContract
{
    public function generate(Order $order): Invoice
    {
        $order->loadMissing(['transaction', 'products', 'status']);
        $customer = new Buyer([
            'name' => $order->name . ' ' . $order->lastname,
            'phone' => $order->phone,
            'custom_fields' => [
                'email' => $order->email,
                'city' => $order->city,
                'address' => $order->address,
            ]
        ]);

        $fileName = 'invoices/'.Str::slug($customer->name . ' ' . $order->vendor_order_id);

        $invoice = Facade::make('receipt')
            ->series('BIG')
            ->status($order->status->name)
            ->buyer($customer)
            ->date($order->created_at)
            ->filename($fileName)
            ->taxRate(config('paypal.tax'))
            ->addItems($this->invoiceItems($order->products))
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->save('s3');

        if ($order->status->name === OrderStatusEnum::IN_PROCESS->value) {
            $invoice->payUntilDays(config('invoices.date.pay_until_days'));
        }
        return $invoice;
    }

    protected function invoiceItems(Collection $products): array
    {
        $items = [];
        foreach ($products as $product) {
            $items[] = InvoiceItem::make($product->title)
                ->pricePerUnit($product->pivot->single_price)
                ->quantity($product->pivot->quantity)
                ->units('pc');
        }
        return $items;
    }
}
