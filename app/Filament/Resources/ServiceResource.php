<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Plan;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use stdClass;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Service';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Manajemen Warehouse';

    protected static ?string $slug = 'service-check';

    protected static ?string $breadcrumb = 'Service & Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service & Check Report')
                    ->schema([
                        Forms\Components\DatePicker::make('tgl_cek')
                            ->label('Tanggal Cek')
                            ->required()
                            ->validationMessages([
                                'required' => 'Tanggal Cek wajib diisi.',
                            ])
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\Select::make('genset_id')
                            ->required()
                            ->validationMessages([
                                'required' => 'Genset wajib diisi.',
                            ])
                            ->placeholder('Pilih Genset')
                            ->label('Genset')
                            ->relationship(
                                name: 'genset',
                                titleAttribute: 'brand_engine',
                                modifyQueryUsing: function (Builder $query) {
                                    $query
                                        ->whereHas('plans', fn(Builder $q) => $q->where('jobdesk', 'service'));
                                },
                            )
                            ->searchable()
                            ->native(false)
                            ->preload()
                            ->live()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')')
                            ->afterStateUpdated(function (Set $set) {
                                $set('order_id', null);
                                $set('operator_id', null);
                            }),
                        Forms\Components\Select::make('order_id')
                            ->label('Customer')
                            ->required()
                            ->native(false)
                            ->unique(ignoreRecord: true)
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih Customer')
                            ->live()
                            ->visible(fn(Get $get) => $get('genset_id'))
                            ->afterStateUpdated(function (Set $set) {
                                $set('operator_id', null);
                            })
                            ->relationship(
                                name: 'transaction',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    if ($get('genset_id')) {
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

                        Forms\Components\Select::make('users')
                            ->label('Mekanik')
                            ->placeholder('Pilih Mekanik')
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->native(false)
                            ->visible(fn(Get $get) => $get('genset_id') && $get('order_id'))
                            ->relationship(
                                name: 'users',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    if ($get('order_id')) {
                                        $query
                                            // ->where('status', 'bertugas')
                                            ->whereHas('plans', fn(Builder $q) => $q->where('order_id', $get('order_id'))->where('jobdesk', 'service'));
                                    } else {
                                        $query->where('status', 'bertugas');
                                    }
                                },
                            )
                    ])
                    ->collapsible()
                    ->columns(2),
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Service Report')
                        ->schema([
                            FileUpload::make('service_report')
                                ->label('Foto')
                                ->directory('service')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->openable()
                                ->image(),
                        ])->collapsible(),
                    Forms\Components\Section::make('Check List')
                        ->schema([
                            FileUpload::make('check_list')
                                ->label('Foto')
                                ->directory('service')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->image()
                                ->openable(),
                        ])->collapsible()
                ])->columnSpanFull(),
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Foto Kondisi Genset')
                        ->schema([
                            FileUpload::make('foto_service')
                                ->label('Foto')
                                ->directory('service')
                                ->multiple()
                                ->image()
                                ->panelLayout('grid')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->openable(),
                        ])->collapsible(),
                    Forms\Components\Section::make('Surat Permintaan Barang')
                        ->schema([
                            FileUpload::make('part_request')
                                ->label('Foto')
                                ->directory('service')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->image()
                                ->openable(),
                        ])->collapsible()
                ])->columnSpanFull(),
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
                Tables\Columns\ImageColumn::make('foto_service')
                    ->label('Foto Service')
                    ->circular()
                    ->stacked()
                    ->simpleLightbox(),
                Tables\Columns\TextColumn::make('genset.brand_engine')
                    ->label('Genset')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn(Model $record) => str()->upper($record->genset->brand_engine) . ' ' . $record->genset->kapasitas . ' KVA'),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Mekanik')
                    ->bulleted()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction.customer')
                    ->label('Customer')
                    ->wrap()
                    ->searchable()
                    ->formatStateUsing(function (Service $record) {
                        return $record->transaction->customer->perusahaan  ? $record->transaction->customer->perusahaan : $record->transaction->customer->name;
                    }),
                Tables\Columns\TextColumn::make('transaction.site')
                    ->label('Site')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
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
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                Tables\Filters\SelectFilter::make('genset_id')
                    ->label('Genset')
                    ->relationship(
                        name: 'genset',
                        titleAttribute: 'brand_engine',
                        // modifyQueryUsing: fn(Builder $query) => $query->where('role', '!=', 'admin')
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('service_report')
                        ->label('Service Report')
                        ->icon('heroicon-o-document-text')
                        ->url(fn(Model $record): string => url('storage', $record->service_report))
                        ->hidden(fn(Model $record): bool => $record->service_report == null)
                        ->openUrlInNewTab()
                        ->color(Color::Indigo),
                    Tables\Actions\Action::make('check_list')
                        ->label('Check List Report')
                        ->icon('heroicon-o-document-text')
                        ->url(fn(Model $record): string => url('storage', $record->check_list))
                        ->hidden(fn(Model $record): bool => $record->check_list == null)
                        ->openUrlInNewTab()
                        ->color(Color::Purple),
                    Tables\Actions\Action::make('part_request')
                        ->label('Permintaan Barang')
                        ->icon('heroicon-o-document-text')
                        ->url(fn(Model $record): string => url('storage', $record->part_request))
                        ->hidden(fn(Model $record): bool => $record->part_request == null)
                        ->openUrlInNewTab()
                        ->color(Color::Teal),
                ])
                    ->icon('heroicon-o-document-text')
                    ->color(Color::Rose),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\DeleteAction::make()
                        ->before(fn(Model $record) => $record->users()->detach())
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
