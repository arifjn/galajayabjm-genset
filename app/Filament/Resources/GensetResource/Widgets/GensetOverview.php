<?php

namespace App\Filament\Resources\GensetResource\Widgets;

use App\Models\Genset;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GensetOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Ready', Genset::query()->where('status_genset', 'ready')->count()),
            Stat::make('Rent', Genset::query()->where('status_genset', 'rent')->count()),
            Stat::make('Maintenance', Genset::query()
                ->orWhere('status_genset', 'maintenance')->count()),
        ];
    }
}
