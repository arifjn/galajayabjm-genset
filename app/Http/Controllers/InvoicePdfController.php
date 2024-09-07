<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoicePdfController extends Controller
{
    public function pdf(Transaction $transaction)
    {
        return Pdf::loadView('pdf.invoice', ['order' => $transaction])
            ->setPaper('a4', 'portrait')
            ->stream('laporan-invoice.pdf');
    }
}
