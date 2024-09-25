<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanIncomeResource\Pages;
use App\Filament\Resources\LaporanIncomeResource\RelationManagers;
use App\Models\Income;
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
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationLabel = 'Laporan Pendapatan';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 7;

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
                Tables\Columns\TextColumn::make('transaction.order_id')
                    ->label('Order ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction')
                    ->label('Transaksi')
                    ->sortable()
                    // ->formatStateUsing(
                    //     fn(Model $record) => ucwords($record->transaction->subject) . ' Genset ' . $record->transaction->kapasitas
                    // )
                    ->getStateUsing(
                        fn(Model $record) => ucwords($record->transaction->subject) . ' Genset ' . ($record->transaction->kapasitas ? $record->transaction->kapasitas : $record->transaction->genset->kapasitas) . ' KVA'
                    ),
                Tables\Columns\TextColumn::make('transaction.created_at')
                    ->label('Tanggal Order')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.harga')
                    ->label('Biaya Sewa')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->transaction->harga, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.biaya_operator')
                    ->label('Biaya Operator')
                    ->formatStateUsing(fn(Model $record) => $record->transaction->biaya_operator != null ? Number::currency($record->transaction->biaya_operator, 'IDR', 'id') : Number::currency(0, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.denda')
                    ->label('Denda Overtime')
                    ->formatStateUsing(fn(Model $record) => $record->transaction->denda != null ? Number::currency($record->transaction->denda, 'IDR', 'id') : Number::currency(0, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('income')
                    ->label('Total Pendapatan')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->income, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ManageLaporanIncomes::route('/'),
        ];
    }
}
