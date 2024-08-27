<?php

namespace App\Filament\Operator\Resources\DailyReportResource\Pages;

use App\Filament\Operator\Resources\DailyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditDailyReport extends EditRecord
{
    protected static string $resource = DailyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Edit Daily Report';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
