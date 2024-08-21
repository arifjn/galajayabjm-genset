<?php

namespace App\Filament\Resources\LaporanTransaksiResource\Pages;

use App\Filament\Resources\LaporanTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageLaporanTransaksis extends ManageRecords
{
    protected static string $resource = LaporanTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Semua Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.order'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Transaksi';
    }
}
