<?php

namespace App\Filament\Operator\Resources\JobdeskResource\Pages;

use App\Filament\Operator\Resources\JobdeskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobdesk extends EditRecord
{
    protected static string $resource = JobdeskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
