<?php

namespace App\Filament\Resources\LaporanIncomeResource\Pages;

use App\Filament\Resources\LaporanIncomeResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ManageIncomes extends ManageRecords
{
    protected static string $resource = LaporanIncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('Cetak Laporan')
                ->color(Color::Indigo)
                ->icon('heroicon-o-printer')
                ->url(fn() => route('pdf.income'))
                ->openUrlInNewTab(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Laporan Pendapatan';
    }

    public function getTabs(): array
    {
        return [
            'Januari' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 1)),
            'Februari' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 2)),
            'Maret' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 3)),
            'April' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 4)),
            'Mei' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 5)),
            'Juni' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 6)),
            'Juli' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 7)),
            'Agustus' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 8)),
            'September' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 9)),
            'Oktober' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 10)),
            'November' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 11)),
            'Desember' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->whereMonth('created_at', 12)),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        $date = Carbon::parse(Carbon::now()->format('F'))->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        return $date->format('F');
    }
}
