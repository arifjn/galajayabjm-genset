<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServiceWorkPdfController extends Controller
{
    public function pdf(Plan $plan)
    {
        return Pdf::loadView('pdf.st-service', ['plan' => $plan])
            ->setPaper('a5', 'portrait')
            ->stream('service-work.pdf');
    }
}
