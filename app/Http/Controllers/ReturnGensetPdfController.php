<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReturnGensetPdfController extends Controller
{
    public function pdf(Plan $plan)
    {
        return Pdf::loadView('pdf.spk-penarikan', ['plan' => $plan])
            ->setPaper('b5', 'portrait')
            ->stream('penarikan-gs.pdf');
    }
}
