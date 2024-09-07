<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Pendapatan';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $slug = 'pendapatan';

    protected static ?string $breadcrumb = 'Pendapatan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\Select::make('transaction_id')
                            ->label('Transaksi')
                            ->required()
                            ->validationMessages([
                                'required' => 'Transaksi wajib diisi.',
                            ])
                            ->placeholder('Pilih Transaksi')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->live()
                            ->relationship(
                                name: 'transaction',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('status_transaksi', 'selesai')->orWhere('status_transaksi', 'dibayar');
                                },
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => ucwords($record->subject) . ' Genset ' . ($record->kapasitas ? $record->kapasitas : $record->genset->kapasitas) . ' KVA' . ' (' . $record->order_id . ')'),
                        Forms\Components\TextInput::make('overtime')
                            ->label('Kelebihan Jam')
                            ->numeric()
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->live(onBlur: true)
                            ->suffix('Jam'),
                        Forms\Components\Placeholder::make('denda_placheholder')
                            ->label('Denda Kelebihan Jam Sewa')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;

                                if ($get('transaction_id') == null) {
                                    $denda = 0;
                                }

                                if ($get('transaction_id')) {
                                    $order = Transaction::where('id', $get('transaction_id'))->first();
                                    $denda = ($order->harga * 0.295) / 100;
                                }

                                if ($get('overtime') > 0) {
                                    $total = $get('overtime') * $denda;
                                }

                                $set('denda', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Forms\Components\Hidden::make('denda')
                            ->dehydrated()
                            ->default(0),
                        Forms\Components\Placeholder::make('income_placheholder')
                            ->label('Pendapatan Bersih')
                            ->content(function (Get $get, Set $set) {

                                $order = Transaction::where('id', $get('transaction_id'))->first();
                                $total =  0;

                                if ($order) {
                                    $total = $order->harga;
                                }

                                if ($get('denda') > 0) {
                                    $total = $get('denda') + $order->harga + $order->biaya_operator;
                                }

                                $set('income', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Forms\Components\Hidden::make('income')
                            ->dehydrated()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->collapsible(),
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
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->transaction->biaya_operator, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('denda')
                    ->formatStateUsing(fn(Model $record) => Number::currency($record->denda, 'IDR', 'id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('income')
                    ->label('Pendapatan Bersih')
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
