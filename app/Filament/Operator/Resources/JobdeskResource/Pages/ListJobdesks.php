<?php

namespace App\Filament\Operator\Resources\JobdeskResource\Pages;

use App\Filament\Operator\Resources\JobdeskResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListJobdesks extends ListRecords
{
    protected static string $resource = JobdeskResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make()
    //             ->label('Tambah'),
    //     ];
    // }

    public function getTitle(): string|Htmlable
    {
        return 'Jobdesk';
    }
}
