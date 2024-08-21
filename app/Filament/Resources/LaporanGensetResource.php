<?php

namespace App\Filament\Resources;

use App\Enums\BrandEngine;
use App\Filament\Resources\LaporanGensetResource\Pages;
use App\Filament\Resources\LaporanGensetResource\RelationManagers;
use App\Models\Genset;
use App\Models\LaporanGenset;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use stdClass;

class LaporanGensetResource extends Resource
{
    protected static ?string $model = Genset::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Genset';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'laporan-genset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                TextColumn::make('no_genset')
                    ->label('Nomor Genset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_engine')
                    ->label('Tipe Engine')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand_engine')
                    ->label('Brand Engine')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kapasitas')
                    ->suffix(' kVA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_genset')
                    ->label('Tipe Genset')
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_genset')
                    ->label('Status')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ready' => 'success',
                        'rent' => 'warning',
                        'maintenance' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'ready' => 'heroicon-o-check-circle',
                        'rent' => 'heroicon-o-bolt',
                        'maintenance' => 'heroicon-o-wrench-screwdriver',
                    })
                    ->sortable(),
            ])
            ->defaultSort('status_genset', 'ASC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                SelectFilter::make('status_genset')
                    ->label('Status Genset')
                    ->options([
                        'ready' => 'Ready',
                        'rent' => 'Rent',
                        'maintenance' => 'Maintenance',
                    ]),
                SelectFilter::make('brand_engine')
                    ->label('Brand Engine')
                    ->options(BrandEngine::class)
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-genset')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.genset', ['gensets' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-genset.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporanGensets::route('/'),
        ];
    }
}
