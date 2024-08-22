<?php

namespace App\Filament\Resources\LaporanServiceResource\Pages;

use App\Filament\Resources\LaporanServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageLaporanServices extends ManageRecords
{
    protected static string $resource = LaporanServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.service'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Service & Maintenance Check';
    }
}
