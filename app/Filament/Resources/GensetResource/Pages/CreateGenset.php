<?php

namespace App\Filament\Resources\GensetResource\Pages;

use App\Filament\Resources\GensetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateGenset extends CreateRecord
{
    protected static string $resource = GensetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Genset';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }
}
