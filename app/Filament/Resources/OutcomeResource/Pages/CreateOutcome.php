<?php

namespace App\Filament\Resources\OutcomeResource\Pages;

use App\Filament\Resources\OutcomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateOutcome extends CreateRecord
{
    protected static string $resource = OutcomeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Pengeluaran';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }
}
