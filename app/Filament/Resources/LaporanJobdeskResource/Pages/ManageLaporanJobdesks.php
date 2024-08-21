<?php

namespace App\Filament\Resources\LaporanJobdeskResource\Pages;

use App\Filament\Resources\LaporanJobdeskResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLaporanJobdesks extends ManageRecords
{
    protected static string $resource = LaporanJobdeskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
