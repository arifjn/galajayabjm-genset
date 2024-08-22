<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OutcomePdfController extends Controller
{
    public function pdf()
    {
        $outcomes = Outcome::orderBy('created_at', 'DESC')->with('plan')
            ->get();
        return Pdf::loadView('pdf.outcome', ['outcomes' => $outcomes])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-outcome.pdf');
    }
}
