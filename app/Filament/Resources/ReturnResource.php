<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnResource\Pages;
use App\Filament\Resources\ReturnResource\RelationManagers;
use App\Models\Genset;
use App\Models\Plan;
use App\Models\Return;
use App\Models\Transaction;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class ReturnResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Pengembalian';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $slug = 'transaksi';

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
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_job_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d F Y')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gensets')
                    ->label('Genset')
                    ->searchable(['brand_engine', 'kapasitas'])
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->gensets as $genset) {
                            $html .= '<li>' . str()->upper($genset->brand_engine) . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Mekanik')
                    ->bulleted(fn(Plan $record) => $record->users->count() > 1)
                    ->searchable()
                    ->default('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('operator.name')
                    ->default('-')
                    ->label('Operator')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->wrap(),
                // ->limit(20)
                // ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                //     $state = $column->getState();

                //     if (strlen($state) <= $column->getCharacterLimit()) {
                //         return null;
                //     }

                //     // Only render the tooltip if the column content exceeds the length limit.
                //     return $state;
                // }),
                Tables\Columns\TextColumn::make('transaction.customer')
                    ->label('Customer')
                    ->sortable()
                    ->wrap()
                    ->formatStateUsing(function (Plan $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'delivery' => 'info',
                        'rent' => 'primary',
                        'selesai' => 'success',
                        'cancel' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-exclamation-circle',
                        'delivery' => 'heroicon-o-truck',
                        'rent' => 'heroicon-o-bolt',
                        'selesai' => 'heroicon-o-check-circle',
                        'cancel' => 'heroicon-o-x-circle',
                    })
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
            ->defaultSort('tanggal_job', 'DESC')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('return')
                    ->visible(fn(Plan $record) => $record->tanggal_job_selesai <= now())
                    ->label('Kembalikan')
                    ->color(Color::Teal)
                    ->icon('heroicon-o-arrow-path-rounded-square')
                    ->mountUsing(fn(Forms\ComponentContainer $form, Plan $record) => $form->fill([
                        'order_id' => $record->order_id,
                        'tanggal_kembali' => now(),
                    ]))
                    ->form([
                        Forms\Components\TextInput::make('order_id')
                            ->label('Order ID')
                            ->live()
                            ->readOnly(),
                        Forms\Components\DatePicker::make('tanggal_kembali')
                            ->label('Tanggal Kembali')
                            ->required()
                            ->validationMessages([
                                'required' => 'Tanggal Kembali wajib diisi.',
                            ])
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y'),
                        Forms\Components\Toggle::make('hour_meter')
                            ->live()
                            ->label('Kelebihan Jam Sewa Genset')
                            ->default(false),
                        Forms\Components\TextInput::make('overtime')
                            ->visible(fn(Get $get) => $get('hour_meter'))
                            ->label('Kelebihan Jam')
                            ->numeric()
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->live(onBlur: true)
                            ->suffix('Jam'),
                        Forms\Components\Placeholder::make('denda_placheholder')
                            ->visible(fn(Get $get) => $get('hour_meter'))
                            ->label('Denda Kelebihan Jam Sewa')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;

                                if ($get('order_id')) {
                                    $order = Transaction::where('order_id', $get('order_id'))->first();
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
                    ])
                    ->action(function (Plan $record, array $data) {
                        $record->tanggal_kembali = $data['tanggal_kembali'];
                        $record->status = 'selesai';

                        if ($record->gensets) {
                            foreach ($record->gensets as $genset) {
                                $gs = Genset::find($genset->id);
                                $gs->status_genset = 'ready';
                                $gs->save();
                            }
                        }

                        if ($record->users && $record->status != 'selesai') {
                            foreach ($record->users as $user) {
                                $u = User::find($user->id);
                                $u->status = 'tersedia';
                                $u->save();
                            }
                        }
                        if ($record->operator_id) {
                            $u = User::find($record->operator_id);
                            $u->status = 'tersedia';
                            $u->save();
                        }

                        // $record->gensets()->detach();
                        // $record->users()->detach();

                        $record->save();

                        $transaction = Transaction::where('order_id', $data['order_id'])->first();
                        $transaction->denda = $data['denda'];
                        // $transaction->status_transaksi = 'selesai';
                        $transaction->save();
                    })
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-m-arrow-path-rounded-square')
                    ->modalIconColor('success')
                    ->modalSubmitActionLabel('Kembalikan')
                    ->modalSubmitAction(
                        fn(\Filament\Actions\StaticAction $action) =>
                        $action->color('success')
                    )
                    ->modalDescription('Kembalikan Genset jika sudah selesai di rental!'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReturns::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'rent');
    }
}
