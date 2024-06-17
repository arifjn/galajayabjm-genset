<?php

namespace App\Filament\Resources\GensetResource\Pages;

use App\Filament\Resources\GensetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListGensets extends ListRecords
{
    protected static string $resource = GensetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Genset';
    }
}
