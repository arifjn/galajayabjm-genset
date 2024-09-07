<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use App\Models\Outcome;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $income = new Income();
        $outcome = new Outcome();

        $laba = Income::query()->sum('income') - Outcome::query()->sum('outcome');

        return [
            Stat::make('New Orders', Transaction::query()
                ->where('status_transaksi', 'penawaran')
                ->orWhere('status_transaksi', 'pembayaran')
                ->count()),
            Stat::make('Total Pendapatan', $income ? Number::currency(Income::query()->sum('income'), 'IDR', 'ID') : 0),
            Stat::make('Total Pengeluaran', $outcome ? Number::currency(Outcome::query()->sum('outcome'), 'IDR', 'ID') : 0),
            Stat::make('Laba Bersih', $laba ? Number::currency($laba, 'IDR', 'ID') : 0)
        ];
    }
}
