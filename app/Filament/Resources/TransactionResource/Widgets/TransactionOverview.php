<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Transaction::query()->where('status_transaksi', 'pending')->count()),
            Stat::make('Order Paid', Transaction::query()->where('status_transaksi', 'dibayar')->count()),
            Stat::make('Order Completed', Transaction::query()
                ->orWhere('status_transaksi', 'selesai')
                ->count()),
        ];
    }
}
