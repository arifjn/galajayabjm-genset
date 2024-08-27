<?php

namespace App\Filament\Operator\Resources;

use App\Filament\Operator\Resources\DailyReportResource\Pages;
use App\Filament\Operator\Resources\DailyReportResource\RelationManagers;
use App\Models\DailyReport;
use App\Models\Monitoring;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class DailyReportResource extends Resource
{
    protected static ?string $model = Monitoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Daily Report';

    protected static ?string $slug = 'daily-report';

    protected static ?string $breadcrumb = 'Daily Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Monitoring Information')
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
                                    $query->where('status_genset', 'rent')
                                        ->whereHas('plans', fn(Builder $q) => $q->where('operator_id', auth()->user()->id));
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
                        Forms\Components\Select::make('operator_id')
                            ->label('Operator')
                            ->placeholder('Pilih Operator')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->visible(fn(Get $get) => $get('genset_id') && $get('order_id'))
                            ->relationship(
                                name: 'operator',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    if ($get('genset_id')) {
                                        $operator = Plan::whereHas('gensets', fn(Builder $q) => $q->where('genset_id', $get('genset_id')))->get('operator_id');
                                        if ($operator[0]->operator_id) {
                                            $query->where('status', 'bertugas')
                                                ->whereHas('plan', fn(Builder $q) => $q->whereIn('operator_id', $operator));
                                        } else {
                                            $query->where('status', 'bertugas');
                                        }
                                    } else {
                                        $query->where('status', 'bertugas');
                                    }
                                },
                            )
                    ])
                    ->collapsible()
                    ->columns(2),
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Kondisi Genset')
                        ->schema([
                            FileUpload::make('foto_rental')
                                ->label('Foto')
                                ->directory('rental')
                                ->multiple()
                                ->image()
                                ->panelLayout('grid')
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->openable(),
                        ])->collapsible(),
                    Forms\Components\Section::make('Daily Report')
                        ->schema([
                            FileUpload::make('daily_report')
                                ->label('Foto')
                                ->directory('rental')
                                ->image()
                                ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                ->openable()
                                // ->acceptedFileTypes(['application/pdf']),
                                ->openable(),
                        ])->collapsible()
                ])->columnSpanFull()

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
                    ->formatStateUsing(fn(Model $record) => str()->upper($record->genset->brand_engine) . ' ' . $record->genset->kapasitas . ' KVA'),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDailyReports::route('/'),
            'create' => Pages\CreateDailyReport::route('/create'),
            'edit' => Pages\EditDailyReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('operator_id', auth()->user()->id);
    }
}
