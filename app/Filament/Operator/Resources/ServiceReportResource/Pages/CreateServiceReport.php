<?php

namespace App\Filament\Operator\Resources\ServiceReportResource\Pages;

use App\Filament\Operator\Resources\ServiceReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateServiceReport extends CreateRecord
{
    protected static string $resource = ServiceReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Service & Check Report';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }
}
