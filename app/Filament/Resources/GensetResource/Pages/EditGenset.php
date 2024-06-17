<?php

namespace App\Filament\Resources\GensetResource\Pages;

use App\Filament\Resources\GensetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGenset extends EditRecord
{
    protected static string $resource = GensetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
