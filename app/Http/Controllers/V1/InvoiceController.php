<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Contracts\InvoiceServiceContract;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, InvoiceServiceContract $invoiceService)
    {
        $this->authorize('view', $order);
        return $invoiceService->generate($order)->url();
    }
}
