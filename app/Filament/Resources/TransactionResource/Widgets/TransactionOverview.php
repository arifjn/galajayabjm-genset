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
            Stat::make('New Orders', Transaction::query()
                ->where('status_transaksi', 'penawaran')
                ->orWhere('status_transaksi', 'pembayaran')
                ->count()),
            Stat::make('Order Paid', Transaction::query()
                ->where('status_transaksi', 'dibayar')
                ->orWhere('status_transaksi', 'selesai')
                ->count()),
            Stat::make('Order Completed', Transaction::query()
                ->where('status_transaksi', 'selesai')
                ->count()),
        ];
    }
}
