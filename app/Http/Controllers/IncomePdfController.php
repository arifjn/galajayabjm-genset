<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class IncomePdfController extends Controller
{
    public function pdf()
    {
        $incomes = Transaction::where('status_transaksi', 'dibayar')
            ->orWhere('status_transaksi', 'selesai')
            ->orderBy('created_at', 'DESC')
            ->get();
        return Pdf::loadView('pdf.income', ['incomes' => $incomes])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-income.pdf');
    }
}
