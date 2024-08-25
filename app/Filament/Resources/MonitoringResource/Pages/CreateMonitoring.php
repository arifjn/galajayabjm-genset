<?php

namespace App\Filament\Resources\MonitoringResource\Pages;

use App\Filament\Resources\MonitoringResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateMonitoring extends CreateRecord
{
    protected static string $resource = MonitoringResource::class;

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
