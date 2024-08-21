<?php

namespace App\Filament\Resources\LaporanOperatorResource\Pages;

use App\Filament\Resources\LaporanOperatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageLaporanOperators extends ManageRecords
{
    protected static string $resource = LaporanOperatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Semua Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.operator'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Operator';
    }
}
