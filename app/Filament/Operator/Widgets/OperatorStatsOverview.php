<?php

namespace App\Filament\Operator\Widgets;

use App\Models\Monitoring;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class OperatorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Daily Operation Report', Monitoring::query()
                ->where('operator_id', auth()->user()->id)
                ->count()),
            Stat::make('Service & Check Report', Service::query()
                ->whereHas('users', fn(Builder $q) => $q->where('user_id', auth()->user()->id))
                ->count()),
        ];
    }

    protected function getColumns(): int
    {
        $count = count($this->getCachedStats());

        if ($count < 3) {
            return 2;
        }

        if (($count % 3) !== 1) {
            return 3;
        }

        return 4;
    }
}
