<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DeliveryOrderPdfController extends Controller
{
    public function pdf(Plan $plan)
    {
        return Pdf::loadView('pdf.delivery', ['plan' => $plan])
            ->setPaper('a5', 'landscape')
            ->stream('delivery-order.pdf');
    }
}
