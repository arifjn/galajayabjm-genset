<?php

namespace App\Filament\Operator\Resources\JobdeskOperatorResource\Pages;

use App\Filament\Operator\Resources\JobdeskOperatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageJobdeskOperators extends ManageRecords
{
    protected static string $resource = JobdeskOperatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Daftar Pekerjaan';
    }
}
