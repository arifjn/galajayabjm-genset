<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DendaPdfController extends Controller
{
    public function pdf(Transaction $transaction)
    {
        $awal = Carbon::parse($transaction->tgl_sewa);
        $akhir = Carbon::parse($transaction->tgl_selesai);
        $durasi = $awal->diffInDays($akhir);

        return Pdf::loadView(
            'pdf.denda',
            [
                'order' => $transaction,
                'plan' => Plan::where('order_id', $transaction->order_id)->first(),
                'durasi' => $durasi
            ]
        )
            ->setPaper('a4', 'portrait')
            ->stream('laporan-denda.pdf');
    }
}
