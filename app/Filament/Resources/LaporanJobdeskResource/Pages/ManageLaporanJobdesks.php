<?php

namespace App\Filament\Resources\LaporanJobdeskResource\Pages;

use App\Filament\Resources\LaporanJobdeskResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ManageLaporanJobdesks extends ManageRecords
{
    protected static string $resource = LaporanJobdeskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Semua Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.jobdesk'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Penugasan Operator';
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

    public function getDefaultActiveTab(): string | int | null
    {
        return 'All';
    }
}
