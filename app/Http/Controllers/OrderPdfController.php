<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderPdfController extends Controller
{
    public function pdf()
    {
        $orders = Transaction::all();
        // $jobdesks = Plan::whereDate('tanggal_job', Carbon::today())->get();
        return Pdf::loadView('pdf.order', ['orders' => $orders])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-jobdesk.pdf');
    }
}
