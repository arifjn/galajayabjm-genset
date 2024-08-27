<?php

namespace App\Filament\Operator\Resources\ServiceReportResource\Pages;

use App\Filament\Operator\Resources\ServiceReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListServiceReports extends ListRecords
{
    protected static string $resource = ServiceReportResource::class;

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
        return 'Service & Check Report';
    }
}
