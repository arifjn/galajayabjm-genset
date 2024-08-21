<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PlanJobPdfController extends Controller
{
    public function pdf()
    {
        // $jobdesks = Plan::all();
        $jobdesks = Plan::whereDate('tanggal_job', Carbon::today())->get();
        return Pdf::loadView('pdf.jobdesk', ['jobdesks' => $jobdesks])
            ->setPaper('a4', 'landscape')
            ->stream('laporan-jobdesk.pdf');
    }
}
