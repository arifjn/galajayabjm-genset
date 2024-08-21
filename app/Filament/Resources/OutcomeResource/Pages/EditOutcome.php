<?php

namespace App\Filament\Resources\OutcomeResource\Pages;

use App\Filament\Resources\OutcomeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditOutcome extends EditRecord
{
    protected static string $resource = OutcomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Edit Pengeluaran';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
