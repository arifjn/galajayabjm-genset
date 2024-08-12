<?php

namespace App\Filament\Resources\ServicePlanResource\Pages;

use App\Filament\Resources\ServicePlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListServicePlans extends ListRecords
{
    protected static string $resource = ServicePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Jadwal Service';
    }
}
