<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Filament\Resources\DeliveryResource\RelationManagers\GensetsRelationManager;
use App\Filament\Resources\DeliveryResource\RelationManagers\UsersRelationManager;
use App\Models\Genset;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Jobdesk';

    protected static ?string $navigationGroup = 'Manajemen Jadwal';

    protected static ?string $slug = 'jobdesk';

    protected static ?string $breadcrumb = 'Jobdesk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Jobdesk Information')
                        ->schema([
                            Forms\Components\Select::make('choose_jobdesk')
                                ->options([
                                    'delivery' => 'Delivery',
                                    'service' => 'Service & Maintenance Check',
                                    'lainnya' => 'Lainnya',
                                ])
                                ->label('Pilih Jobdesk')
                                ->native(false)
                                ->live()
                                ->required()
                                ->placeholder('Pilih Pekerjaan')
                                ->afterStateUpdated(function (Set $set) {
                                    $set('jobdesk', null);
                                    $set('genset_id', null);
                                    $set('order_id', null);
                                    $set('operator_id', null);
                                }),
                            Forms\Components\TextInput::make('jobdesk')
                                ->visible(fn(Get $get) => $get('choose_jobdesk') == 'lainnya'),
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
                        ]),
                    Forms\Components\Section::make('Detail Job Information')
                        ->schema([
                            Forms\Components\Select::make('genset_id')
                                ->label('Genset')
                                ->placeholder('Pilih Genset')
                                ->hidden(fn(string $operation): bool => $operation == 'edit')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->native(false)
                                ->multiple()
                                ->searchable(['brand_engine', 'kapasitas'])
                                ->preload()
                                ->live()
                                ->relationship(
                                    name: 'gensets',
                                    modifyQueryUsing: function (Builder $query, Get $get) {
                                        if ($get('choose_jobdesk') == 'delivery') {
                                            $query->where('status_genset', 'ready');
                                        }
                                    },
                                )
                                ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')'),
                            Forms\Components\Select::make('order_id')
                                ->label('Customer')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->native(false)
                                ->unique(ignoreRecord: true)
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih Customer')
                                ->relationship(
                                    name: 'transaction',
                                    modifyQueryUsing: function (Builder $query, Get $get) {
                                        if ($get('choose_jobdesk') == 'service' && $get('genset_id')) {
                                            $order = Plan::whereHas('gensets', fn(Builder $q) => $q->where('genset_id', $get('genset_id')))->get('order_id');
                                            $query->where('status_transaksi', 'dibayar')
                                                ->with('plan')
                                                ->whereIn('order_id', $order);
                                        } else {
                                            $query->where('status_transaksi', 'dibayar');
                                        }
                                    },
                                )
                                ->getOptionLabelFromRecordUsing(fn(Model $record) => $record->customer->perusahaan ? "{$record->customer->perusahaan}" : "{$record->customer->name}"),
                            Forms\Components\Select::make('operator_id')
                                ->label('Operator')
                                ->placeholder('Pilih Operator')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->native(false)
                                ->visible(fn(Get $get) => $get('choose_jobdesk') == 'delivery')
                                ->options(function ($record) {
                                    return User::where('status', 'tersedia')
                                        // Here, we are filtering out a specific relationship.
                                        ->when($record, function ($query, $record) {
                                            return $query->orWhere('id', $record->operator_id);
                                        })
                                        ->pluck('name', 'id');
                                }),
                            Forms\Components\Select::make('users')
                                ->label('Mekanik')
                                ->placeholder('Pilih Mekanik')
                                ->hidden(fn(string $operation): bool => $operation == 'edit')
                                ->native(false)
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->relationship(
                                    name: 'users',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: function (Builder $query) {
                                        $query->where('status', 'tersedia');
                                    },
                                ),
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
                                    'delivery' => 'Delivery',
                                    'selesai' => 'Selesai',
                                    'cancel' => 'Cancel',
                                ]),
                        ])
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
                        ->visible(fn(Get $get) => $get('choose_jobdesk') == 'delivery')
                        ->collapsed(fn(string $operation): bool => $operation == 'edit' ? 1 : 0),
                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobdesk')
                    ->formatStateUsing(fn(string $state): string => $state == 'service' ? 'Service & Maintenance Check' : str()->title($state))
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_job')
                    ->label('Tanggal Job')
                    ->date('d F Y')
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
                    ->searchable()
                    ->html()
                    ->formatStateUsing(function ($record) {
                        $html = '<ul class="list-inside list-disc">';
                        foreach ($record->users as $user) {
                            $html .= '<li>' . $user->name . '</li>';
                        }
                        if ($record->operator_id) {
                            $html .= '<li>' . $record->operator?->name . '</li>';
                        }
                        $html .= '</ul>';
                        return $html;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.site')
                    ->label('Alamat')
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.customer')
                    ->label('Customer')
                    ->sortable()
                    ->formatStateUsing(function (Plan $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\SelectColumn::make('status')
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'selesai' => 'Selesai',
                    ])
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Jadwal Pengiriman')
                        ->color(Color::Orange),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (Plan $record) {
                            if ($record->gensets) {
                                foreach ($record->gensets as $genset) {
                                    $gs = Genset::find($genset->id);
                                    $gs->status_genset = 'ready';
                                    $gs->save();
                                }
                            }
                            if ($record->users) {
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
                            $record->gensets()->detach();
                            $record->users()->detach();
                        }),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Pengiriman')->schema([
                    TextEntry::make('jobdesk'),
                    TextEntry::make('tanggal_job')
                        ->label('Tanggal Job')
                        ->date('d F Y'),
                    TextEntry::make('tanggal_job_selesai')
                        ->label('Tanggal Selesai')
                        ->date('d F Y'),
                    TextEntry::make('transaction.customer.perusahaan')
                        ->label('Customer')
                        ->formatStateUsing(function (Plan $record) {
                            return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                        }),
                    TextEntry::make('gensets')
                        ->label('Genset')
                        ->html()
                        ->formatStateUsing(function ($record) {
                            $html = '<ul class="list-inside list-disc">';
                            foreach ($record->gensets as $genset) {
                                $html .= '<li>' . $genset->brand_engine . ' ' . $genset->kapasitas . ' KVA' . '</li>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }),
                    TextEntry::make('users.name')
                        ->label('Operator')
                        ->bulleted(),
                    TextEntry::make('transaction.site')
                        ->label('Alamat Pengiriman')
                        ->columns(2),
                    TextEntry::make('status')
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                            'pending' => 'Pending',
                            'delivery' => 'Delivery',
                            'selesai' => 'Selesai',
                            'cancel' => 'Cancel',
                        })
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'pending' => 'warning',
                            'delivery' => 'info',
                            'selesai' => 'success',
                            'cancel' => 'danger',
                        })
                        ->icon(fn(string $state): string => match ($state) {
                            'pending' => 'heroicon-o-information-circle',
                            'delivery' => 'heroicon-o-truck',
                            'selesai' => 'heroicon-o-check-badge',
                            'cancel' => 'heroicon-o-x-mark',
                        })
                        ->label('Status'),
                ])->columns(3)->collapsible(),
                Section::make('Informasi Mob Demob')->schema([
                    TextEntry::make('nama_supir')
                        ->label('Nama Supir'),
                    TextEntry::make('nohp_supir')
                        ->label('No. HP'),
                    TextEntry::make('jenis_mobil')
                        ->label('Jenis Mobil'),
                    TextEntry::make('plat_mobil')
                        ->label('Plat'),
                ])
                    ->visible(fn(Model $record) => $record->nama_supir)
                    ->columns(2)->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            GensetsRelationManager::class,
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
