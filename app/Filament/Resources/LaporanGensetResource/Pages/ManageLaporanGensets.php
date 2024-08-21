<?php

namespace App\Filament\Resources\LaporanGensetResource\Pages;

use App\Filament\Resources\LaporanGensetResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageLaporanGensets extends ManageRecords
{
    protected static string $resource = LaporanGensetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Semua Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.genset'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Genset';
    }
}
