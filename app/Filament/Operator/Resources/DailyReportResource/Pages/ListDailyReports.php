<?php

namespace App\Filament\Operator\Resources\DailyReportResource\Pages;

use App\Filament\Operator\Resources\DailyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListDailyReports extends ListRecords
{
    protected static string $resource = DailyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Daily Report Check';
    }
}
