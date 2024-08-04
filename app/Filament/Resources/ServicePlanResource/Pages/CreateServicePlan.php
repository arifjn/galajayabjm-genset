<?php

namespace App\Filament\Resources\ServicePlanResource\Pages;

use App\Filament\Resources\ServicePlanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateServicePlan extends CreateRecord
{
    protected static string $resource = ServicePlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Service Plan';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }
}
