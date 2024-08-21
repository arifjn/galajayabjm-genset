<?php

namespace App\Http\Controllers;

use App\Models\Genset;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Request;

class GensetPdfController extends Controller
{
    public function pdf(Request $request)
    {
        $gensets = Genset::all();
        return Pdf::loadView('pdf.genset', ['gensets' => $gensets])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-genset.pdf');
    }
}
