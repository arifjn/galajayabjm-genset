<?php

namespace App\Filament\Resources\MonitoringResource\Pages;

use App\Filament\Resources\MonitoringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ListMonitorings extends ListRecords
{
    protected static string $resource = MonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.monitoring'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Monitoring';
    }
}
