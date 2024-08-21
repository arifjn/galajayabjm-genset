<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServicePdfController extends Controller
{
    public function pdf()
    {
        $services = Service::orderBy('tgl_cek', 'ASC')->get();
        return Pdf::loadView('pdf.service', ['services' => $services])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-service.pdf');
    }
}
