<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanRentalResource\Pages;
use App\Filament\Resources\LaporanRentalResource\RelationManagers;
use App\Models\Monitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class LaporanRentalResource extends Resource
{
    protected static ?string $model = Monitoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationLabel = 'Laporan Rental';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'laporan-monitoring';

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
                Tables\Columns\TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('tgl_cek')
                    ->label('Tanggal Cek')
                    ->date('d F Y')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('foto_rental')
                    ->label('Foto Rental')
                    ->circular()
                    ->stacked()
                    ->simpleLightbox(),
                Tables\Columns\TextColumn::make('genset.brand_engine')
                    ->label('Genset')
                    ->searchable()
                    ->formatStateUsing(fn(Model $record) => $record->genset->brand_engine . ' ' . $record->genset->kapasitas . ' KVA'),
                Tables\Columns\TextColumn::make('operator.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction.customer')
                    ->label('Customer')
                    ->wrap()
                    ->searchable()
                    ->formatStateUsing(function (Monitoring $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\TextColumn::make('transaction.site')
                    ->label('Site')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->default('-')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('tgl_cek', 'ASC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                Tables\Filters\SelectFilter::make('operator_id')
                    ->label('Operator')
                    ->relationship(
                        name: 'operator',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('role', '==', 'operator')
                    )
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-monitoring')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.monitoring', ['monitorings' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-monitoring.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporanRentals::route('/'),
        ];
    }
}
