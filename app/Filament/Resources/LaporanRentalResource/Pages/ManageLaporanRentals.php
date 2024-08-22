<?php

namespace App\Filament\Resources\LaporanRentalResource\Pages;

use App\Filament\Resources\LaporanRentalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageLaporanRentals extends ManageRecords
{
    protected static string $resource = LaporanRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Semua Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.monitoring'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Harian Rental';
    }
}
