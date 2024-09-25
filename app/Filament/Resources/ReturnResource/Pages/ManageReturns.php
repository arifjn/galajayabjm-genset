<?php

namespace App\Filament\Resources\ReturnResource\Pages;

use App\Filament\Resources\ReturnResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageReturns extends ManageRecords
{
    protected static string $resource = ReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->label('Tambah')
            //     ->icon('heroicon-o-plus'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Pengembalian';
    }
}
