<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanIncomeResource\Pages;
use App\Filament\Resources\LaporanIncomeResource\RelationManagers;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use stdClass;

class LaporanIncomeResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationLabel = 'Laporan Pendapatan';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 0;

    protected static ?string $slug = 'laporan-pendapatan';

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
                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->date('d F Y')
                    ->wrap()
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->formatStateUsing(fn(string $state): string => str()->title($state) . ' Genset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('durasi_sewa')
                    ->label('Durasi Sewa')
                    ->suffix(' Hari'),
                TextColumn::make('brand_engine')
                    ->label('Brand Engine')
                    ->formatStateUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.perusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->formatStateUsing(fn(Model $record) => $record->customer->perusahaan ? $record->customer->perusahaan : '-')
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->numeric()
                    ->formatStateUsing(fn($state) => Number::currency($state, 'IDR', 'id'))
            ])
            ->defaultSort('status_transaksi', 'DESC')
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-income')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.income', ['incomes' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-income.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageIncomes::route('/'),
        ];
    }
}
