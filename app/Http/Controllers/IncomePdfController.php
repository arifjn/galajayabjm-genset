<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class IncomePdfController extends Controller
{
    public function pdf()
    {
        $incomes = Income::orderBy('created_at', 'DESC')->with('transaction')
            ->get();
        return Pdf::loadView('pdf.income', ['incomes' => $incomes])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-income.pdf');
    }
}
