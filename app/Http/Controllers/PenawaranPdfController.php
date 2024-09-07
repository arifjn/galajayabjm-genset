<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenawaranPdfController extends Controller
{
    public function pdf(Transaction $transaction)
    {
        $awal = Carbon::parse($transaction->tgl_sewa);
        $akhir = Carbon::parse($transaction->tgl_selesai);
        $durasi = $awal->diffInDays($akhir);

        return Pdf::loadView('pdf.penawaran', ['order' => $transaction, 'durasi' => $durasi])
            ->setPaper('a4', 'portrait')
            ->stream('penawaran-harga.pdf');
    }
}
