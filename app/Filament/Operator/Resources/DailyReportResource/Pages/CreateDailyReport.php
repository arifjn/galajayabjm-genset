<?php

namespace App\Filament\Operator\Resources\DailyReportResource\Pages;

use App\Filament\Operator\Resources\DailyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateDailyReport extends CreateRecord
{
    protected static string $resource = DailyReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Daily Report';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }
}
