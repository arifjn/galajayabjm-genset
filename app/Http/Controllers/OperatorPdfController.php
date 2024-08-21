<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class OperatorPdfController extends Controller
{
    public function pdf()
    {
        $operators = User::where('role', '!=', 'admin')->where('role', '!=', 'sales')->get();
        return Pdf::loadView('pdf.operator', ['operators' => $operators])
            ->setPaper('a4', 'portrait')
            ->stream('laporan-operator.pdf');
    }
}
