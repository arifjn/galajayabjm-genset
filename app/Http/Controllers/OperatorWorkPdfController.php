<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OperatorWorkPdfController extends Controller
{
    public function pdf(Plan $plan)
    {
        return Pdf::loadView('pdf.st-operator', ['plan' => $plan])
            ->setPaper('b5', 'portrait')
            ->stream('operator-work.pdf');
    }
}
