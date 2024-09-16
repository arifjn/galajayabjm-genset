<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnResource\Pages;
use App\Filament\Resources\ReturnResource\RelationManagers;
use App\Models\Genset;
use App\Models\Plan;
use App\Models\Return;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Tables\Columns\TextColumn::make('jobdesk')
                    ->formatStateUsing(fn(string $state): string => $state == 'service' ? 'Service & Maintenance Check' : str()->title($state))
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
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
                Tables\Columns\SelectColumn::make('status')
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'delivery' => 'Delivery',
                        'rent' => 'Rent',
                        'selesai' => 'Selesai',
                        'cancel' => 'Cancel',
                    ])
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state == 'rent') {
                            if ($record->users) {
                                foreach ($record->users as $user) {
                                    $u = User::find($user->id);
                                    $u->status = 'tersedia';
                                    $u->save();
                                }
                            }
                        } elseif ($state == 'selesai') {
                            if ($record->users) {
                                foreach ($record->users as $user) {
                                    $u = User::find($user->id);
                                    $u->status = 'tersedia';
                                    $u->save();
                                }
                            }

                            if ($record->gensets) {
                                foreach ($record->gensets as $genset) {
                                    $gs = Genset::find($genset->id);
                                    $gs->status_genset = 'ready';
                                    $gs->save();
                                }
                            }

                            if ($record->operator_id) {
                                $u = User::find($record->operator_id);
                                $u->status = 'tersedia';
                                $u->save();
                            }

                            if ($record->order_id) {
                                $order = Transaction::where('order_id', $record->order_id)->first();
                                $order->status_transaksi = 'selesai';
                                $order->save();
                            }
                        }
                        return $state;
                    })
                    ->selectablePlaceholder(false),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReturns::route('/'),
        ];
    }
}
