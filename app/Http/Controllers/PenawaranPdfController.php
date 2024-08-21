<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PenawaranPdfController extends Controller
{
    public function pdf(Transaction $transaction)
    {
        return Pdf::loadView('pdf.penawaran', ['order' => $transaction])
            ->setPaper('a4', 'portrait')
            ->stream('laporan-penawaran.pdf');
    }
}
