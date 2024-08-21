<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Filament\Resources\PlanResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.jobdesk'))
                ->openUrlInNewTab(),
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Jadwal Pekerjaan';
    }

    public function getTabs(): array
    {
        return [
            'Delivery' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('jobdesk', 'delivery')->where('status', 'pending')->orWhere('status', 'delivery')),
            'Rental' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('jobdesk', 'delivery')->where('status', 'rent')),
            'Service' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('jobdesk', 'service')->where('status', 'pending')),
            'Lainnya' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('jobdesk', 'lainnya')),
            'All' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->orderBy('status', 'DESC')),
        ];
    }
}
