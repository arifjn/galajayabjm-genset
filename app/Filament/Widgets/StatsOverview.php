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
    protected function getStats(): array
    {
        $income = new Income();
        $outcome = new Outcome();

        return [
            Stat::make('New Orders', Transaction::query()->where('status_transaksi', 'pending')->count()),
            Stat::make('Total Pendapatan', $income->income ? Number::currency(Income::query()->avg('income'), 'IDR', 'ID') : 0),
            Stat::make('Total Pengeluaran', $outcome->outcome ? Number::currency(Outcome::query()->avg('outcome'), 'IDR', 'ID') : 0)
        ];
    }
}
