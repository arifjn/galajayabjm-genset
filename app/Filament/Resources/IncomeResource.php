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
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Income Information')
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
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    $transaction = Transaction::where('id', $get('transaction_id'))->first();

                                    if ($transaction != null) {
                                        $transaction->customer->name ? $set('customer', $transaction->customer->name) : $set('customer', $transaction->customer->perusahaan);
                                        $set('order_id', $transaction->order_id);
                                        $set('site', $transaction->site);
                                        $set('status', $transaction->status_transaksi);
                                    }
                                })
                                ->relationship(
                                    name: 'transaction',
                                    modifyQueryUsing: function (Builder $query, $record) {
                                        $query->where('status_transaksi', '!=', 'selesai')->where('status_transaksi', 'dibayar');
                                    },
                                )
                                ->getOptionLabelFromRecordUsing(fn(Model $record) => ucwords($record->subject) . ' Genset ' . ($record->kapasitas ? $record->kapasitas : $record->genset->kapasitas) . ' KVA' . ' (' . $record->order_id . ')')
                                ->columnSpanFull(),

                            Forms\Components\Placeholder::make('sewa_placheholder')
                                ->label('Pendapatan Sewa')
                                ->content(function (Get $get, Set $set) {

                                    $order = Transaction::where('id', $get('transaction_id'))->first();
                                    $total =  0;

                                    if ($order) {
                                        $total = $order->harga;
                                    }

                                    return Number::currency($total, 'IDR', 'ID');
                                }),

                            Forms\Components\Placeholder::make('biaya_operator_placheholder')
                                ->label('Pendapatan Jasa Operator')
                                ->content(function (Get $get, Set $set) {

                                    $order = Transaction::where('id', $get('transaction_id'))->first();
                                    $total =  0;

                                    if ($order && $order->biaya_operator != null) {
                                        $total = $order->biaya_operator;
                                    }

                                    return Number::currency($total, 'IDR', 'ID');
                                }),

                            Forms\Components\Placeholder::make('denda_placheholder')
                                ->label('Pendapatan Denda Overtime')
                                ->content(function (Get $get, Set $set) {

                                    $order = Transaction::where('id', $get('transaction_id'))->first();
                                    $total =  0;

                                    if ($order && $order->denda != null) {
                                        $total = $order->denda;
                                    }

                                    return Number::currency($total, 'IDR', 'ID');
                                }),

                            Forms\Components\Placeholder::make('income_placheholder')
                                ->label('Total Pendapatan')
                                ->content(function (Get $get, Set $set) {

                                    $order = Transaction::where('id', $get('transaction_id'))->first();
                                    $total =  0;

                                    if ($order) {
                                        $total = $order->harga + $order->biaya_operator + $order->denda;
                                    }

                                    $set('income', $total);
                                    return Number::currency($total, 'IDR', 'ID');
                                })
                                ->columnSpanFull(),

                            Forms\Components\Hidden::make('income')
                                ->dehydrated()
                                ->default(0),
                        ])
                        ->collapsible(),
                    Forms\Components\Section::make('Order Details')
                        ->schema([
                            Forms\Components\TextInput::make('order_id')
                                ->label('Order ID')
                                ->disabled(),
                            Forms\Components\TextInput::make('customer')
                                ->label('Customer')
                                ->disabled(),
                            Forms\Components\TextInput::make('site')
                                ->label('Lokasi Proyek')
                                ->disabled(),
                            Forms\Components\ToggleButtons::make('status')
                                ->disabled()
                                ->inline()
                                ->inlineLabel(false)
                                ->options([
                                    'penawaran' => 'Proses Penawaran',
                                    'pembayaran' => 'Proses Pembayaran',
                                    'dibayar' => 'Dibayar',
                                    'selesai' => 'Selesai',
                                    'cancel' => 'Cancel',
                                ])
                                ->colors([
                                    'penawaran' => 'warning',
                                    'pembayaran' => 'primary',
                                    'dibayar' => 'success',
                                    'selesai' => 'success',
                                    'cancel' => 'danger',
                                ])
                                ->icons([
                                    'penawaran' => 'heroicon-o-arrow-path',
                                    'pembayaran' => 'heroicon-o-banknotes',
                                    'dibayar' => 'heroicon-o-check-badge',
                                    'selesai' => 'heroicon-o-check-badge',
                                    'cancel' => 'heroicon-o-x-mark',
                                ]),
                        ]),
                ])
                    ->columnSpanFull(),

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
                Tables\Actions\ActionGroup::make([
                    // Tables\Actions\EditAction::make()
                    //     ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (Income $record) {
                            if ($record->transaction_id) {
                                $transaction = Transaction::find($record->transaction_id);

                                $transaction->status_transaksi = 'dibayar';
                                $transaction->save();
                            }
                        }),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            // 'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
