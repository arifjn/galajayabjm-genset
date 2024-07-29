<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Genset;
use App\Models\GensetPlan;
use App\Models\Plan;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Job Plan';

    protected static ?string $slug = 'job_plan';

    protected static ?string $breadcrumb = 'Job Plan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Job Plan Information')
                    ->schema([
                        Forms\Components\TextInput::make('jobdesk')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('order_id')
                            ->label('Customer')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'transaction',
                                modifyQueryUsing: function (Builder $query, string $operation) {
                                    $query->where('status_transaksi', 'dibayar');
                                },
                                // modifyQueryUsing: function (Builder $query, string $operation) {
                                //     if ($operation == 'create') {
                                //         $query->where('status_transaksi', 'dibayar');
                                //     }
                                // },
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->customer->name}"),
                        Forms\Components\Select::make('genset_id')
                            ->label('Genset')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->multiple()
                            ->searchable(['brand_engine', 'kapasitas'])
                            ->preload()
                            ->relationship(
                                name: 'gensets',
                                modifyQueryUsing: function (Builder $query, string $operation) {
                                    if ($operation == 'create') {
                                        $query->where('status_genset', 'ready');
                                    }
                                },
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->brand_engine} {$record->kapasitas} KVA"),
                        Forms\Components\Select::make('user_id')
                            ->label('Operator')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'users',
                                titleAttribute: 'name',
                                // modifyQueryUsing: function (Builder $query, string $operation) {
                                //     if ($operation == 'create') {
                                //         $query->where('status', 'tersedia');
                                //     } else {
                                //         $query->where('is_admin', 0);
                                //     }
                                // },
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('status', 'tersedia');
                                },
                            ),
                        Forms\Components\DatePicker::make('tanggal_job')
                            ->label('Tanggal Job')
                            ->required()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\DatePicker::make('tanggal_job_selesai')
                            ->label('Tanggal Job Selesai')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\Textarea::make('keterangan')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->maxLength(65535),
                        Forms\Components\Radio::make('status')
                            ->required()
                            ->inline()
                            ->inlineLabel(false)
                            ->default('pending')
                            ->options([
                                'pending' => 'Pending',
                                'selesai' => 'Selesai',
                                'cancel' => 'Cancel',
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Forms\Components\Section::make('Mob Demob Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama_supir')
                            ->label('Nama Supir')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nohp_supir')
                            ->label('No. Telp')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jenis_mobil')
                            ->label('Jenis Mobil')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('plat_mobil')
                            ->label('Plat')
                            ->maxLength(255),
                    ])
                    ->collapsible()
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobdesk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_job_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.customer.name')
                    ->label('Customer')
                    ->default('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gensets')
                    ->label('Genset')
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->gensets as $genset) {
                            $html .= '<li>' . $genset->brand_engine . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->bulleted()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => str()->title($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'selesai' => 'success',
                        'pending' => 'warning',
                        'cancel' => 'danger',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'selesai' => 'heroicon-o-check-circle',
                        'pending' => 'heroicon-o-information-circle',
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Plan $record) {
                        $record->gensets()->detach();
                        $record->users()->detach();
                        if ($record->order_id) {
                            $order = Transaction::find($record->order_id);
                            $order->status_transaksi = 'dibayar';
                            $order->save();
                        }
                    }),
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
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
