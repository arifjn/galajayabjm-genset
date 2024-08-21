<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MonitoringPdfController extends Controller
{
    public function pdf()
    {
        $monitorings = Monitoring::orderBy('tgl_cek', 'ASC')->get();
        return Pdf::loadView('pdf.monitoring', ['monitorings' => $monitorings])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-monitoring.pdf');
    }
}
