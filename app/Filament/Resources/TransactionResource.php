<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Genset;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Actions as ComponentsActions;
use Filament\Forms\Components\Actions\Action as ComponentsActionsAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action as ActionsAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;
use stdClass;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Penawaran';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $slug = 'penawaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Rent Information')
                    ->schema([
                        Forms\Components\Select::make('genset_id')
                            ->label('Genset')
                            ->required()
                            ->validationMessages([
                                'required' => 'Genset wajib diisi.',
                            ])
                            ->placeholder('Pilih Genset')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $gs = Genset::where('id', $get('genset_id'))->first();

                                $gs != null ? $set('harga', $gs->harga) : $set('harga', 0);
                            })
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'genset',
                                modifyQueryUsing: function (Builder $query, $record) {
                                    $query->where('status_genset', 'ready')
                                        ->when($record, function ($query, $record) {
                                            return $query->orWhere('id', $record->genset_id);
                                        });
                                },
                            )
                            ->columnSpanFull()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')'),
                        Forms\Components\Select::make('sales_id')
                            ->label('Sales')
                            ->required()
                            ->validationMessages([
                                'required' => 'Sales wajib diisi.',
                            ])
                            ->placeholder('Pilih Sales')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship(
                                name: 'sale',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('role', 'sales');
                                },
                            ),
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->required()
                            ->validationMessages([
                                'required' => 'Customer wajib diisi.',
                            ])
                            ->placeholder('Pilih Customer')
                            ->native(false)
                            ->relationship(
                                name: 'customer',
                                titleAttribute: 'name',
                            )
                            ->live()
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => $record->perusahaan ? "{$record->perusahaan}" : "{$record->name}"),
                        Forms\Components\DatePicker::make('tgl_sewa')
                            ->label('Mulai Sewa')
                            ->required()
                            ->validationMessages([
                                'required' => 'Tanggal Sewa wajib diisi.',
                            ])
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->visible(fn($operation) => $operation == 'create')
                            ->default(now()),
                        Forms\Components\DatePicker::make('tgl_selesai')
                            ->label('Tanggal Selesai')
                            ->native(false)
                            ->required()
                            ->validationMessages([
                                'required' => 'Tanggal Selesai wajib diisi.',
                            ])
                            ->visible(fn($operation) => $operation == 'create')
                            ->closeOnDateSelection()
                            ->displayFormat('d F Y')
                            ->default(now()),
                        Forms\Components\Textarea::make('site')
                            ->label('Lokasi Proyek')
                            ->visible(fn($operation, Get $get) => $operation == 'create' && $get('customer_id'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Mob Demob Information')
                    ->schema([
                        Select::make('jenis_mobil')
                            ->native(false)
                            ->label('Jenis Angkutan')
                            ->options([
                                'bak_terbuka' => 'Truck Bak Terbuka',
                                'crane' => 'Truck Crane',
                            ])
                            ->live()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('site')
                            ->label('Lokasi Proyek')
                            ->columnSpanFull(),
                        Select::make('jarak')
                            ->native(false)
                            ->label('Jarak')
                            ->live()
                            ->options([
                                '50' => '0 KM - 50 KM',
                                '100' => '50 KM - 100 KM',
                                '>100' => '> 100 KM',
                            ]),
                        Forms\Components\Placeholder::make('mob_demob_placheholder')
                            ->label('Biaya Mob Demob')
                            ->content(function (Get $get, Set $set) {

                                $total =  0;

                                if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '50') {
                                    $total = 4000000;
                                } else if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '100') {
                                    $total = 7000000;
                                } else if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '>100') {
                                    $total = 12000000;
                                } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '50') {
                                    $total = 6500000;
                                } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '100') {
                                    $total = 10000000;
                                } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '>100') {
                                    $total = 15000000;
                                } else {
                                    $total = 0;
                                }

                                $set('mob_demob', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Forms\Components\Hidden::make('mob_demob')
                            ->dehydrated()
                            ->default(0),
                        // TextInput::make('mob_demob')
                        //     ->label('Mob Demob')
                        //     ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                        //     ->mask(RawJs::make('$money($input)'))
                        //     ->stripCharacters(',')
                        //     ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                        //     ->numeric()
                        //     ->reactive()
                        //     ->live(onBlur: true)
                        //     ->default(0)
                        //     ->dehydrated()
                        //     ->prefix('Rp'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Price Information')
                    ->schema([
                        TextInput::make('harga')
                            ->label('Harga Sewa (Perhari)')
                            ->required()
                            ->validationMessages([
                                'required' => 'Harga Sewa wajib diisi.',
                            ])
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->reactive()
                            ->live(onBlur: true)
                            ->prefix('Rp'),

                        Toggle::make('operator')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $get('operator') ? $set('biaya_operator', 100000) : $set('biaya_operator', 0);
                            })
                            ->default(true),
                        TextInput::make('biaya_operator')
                            ->label('Biaya Operator (Perhari)')
                            ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                            ->numeric()
                            ->default(0)
                            ->reactive()
                            ->live(onBlur: true)
                            ->dehydrated()
                            ->visible(fn(Get $get) => $get('operator'))
                            ->prefix('Rp'),
                        TextInput::make('durasi_sewa')
                            ->label('Durasi Sewa')
                            ->live()
                            ->numeric()
                            ->validationMessages([
                                'required' => 'Durasi Sewa wajib diisi.',
                            ])
                            ->required()
                            ->suffix('Hari'),

                        Placeholder::make('sub_total_placheholder')
                            ->label('Sub Total')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;

                                if ($get('harga') == null) {
                                    $set('harga', 0);
                                } elseif ($get('mob_demob') == null) {
                                    $set('mob_demob', 0);
                                } elseif ($get('biaya_operator') == null) {
                                    $set('biaya_operator', 0);
                                }

                                if (floatval(str_replace(',', '', $get('harga'))) > 0) {
                                    $total = (floatval(str_replace(',', '', $get('harga'))) * $get('durasi_sewa')) + floatval(str_replace(',', '', $get('mob_demob'))) + (floatval(str_replace(',', '', $get('biaya_operator'))) * $get('durasi_sewa'));
                                }

                                $set('sub_total', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Hidden::make('sub_total')
                            ->dehydrated()
                            ->default(0),

                        TextInput::make('ppn')
                            ->label('PPN')
                            ->required()
                            ->validationMessages([
                                'required' => 'PPN wajib diisi.',
                            ])
                            ->validationMessages([
                                'required' => 'PPN wajib diisi.',
                            ])
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->dehydrated()
                            ->suffix('%'),


                        Placeholder::make('grand_total_placheholder')
                            ->label('Grand Total (Include PPN)')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                if ($get('ppn') > 0) {
                                    $total = $get('sub_total') + $get('sub_total') * $get('ppn') / 100;
                                }

                                $set('grand_total', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            }),

                        Hidden::make('grand_total')
                            ->default(0),
                    ])
                    ->aside()
                    ->collapsible(),

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
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->formatStateUsing(fn(string $state): string => str()->title($state) . ' Genset')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tgl_sewa')
                    ->label('Mulai Sewa')
                    ->date('d F Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tgl_selesai')
                    ->label('Selesai Sewa')
                    ->date('d F Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kapasitas')
                    ->searchable()
                    ->sortable()
                    ->suffix(' KVA')
                    // ->formatStateUsing(fn(Model $record) => $record->kapasitas ? $record->kapasitas : $record->genset->kapasitas),
                    ->getStateUsing(fn(Model $record) => $record->kapasitas ? $record->kapasitas : $record->genset->kapasitas),
                IconColumn::make('operator')
                    ->icon(fn(string $state): string => match ($state) {
                        '0' => 'heroicon-o-x-circle',
                        '1' => 'heroicon-o-check-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('customer.perusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn(Model $record) => $record->customer->perusahaan ? $record->customer->perusahaan : '-'),
                TextColumn::make('status_transaksi')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'penawaran' => 'Proses Penawaran',
                        'pembayaran' => 'Proses Pembayaran',
                        'dibayar' => 'Dibayar',
                        'denda' => 'Denda',
                        'selesai' => 'Selesai',
                        'cancel' => 'Cancel',
                    })
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'penawaran' => 'warning',
                        'pembayaran' => 'primary',
                        'dibayar' => 'success',
                        'denda' => 'danger',
                        'selesai' => 'success',
                        'cancel' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'penawaran' => 'heroicon-o-arrow-path',
                        'pembayaran' => 'heroicon-o-banknotes',
                        'dibayar' => 'heroicon-o-check-badge',
                        'denda' => 'heroicon-o-banknotes',
                        'selesai' => 'heroicon-o-check-badge',
                        'cancel' => 'heroicon-o-x-mark',
                    }),
            ])
            // ->defaultSort(fn($query) => $query->orderBy('status_transaksi','DESC')->orderBy('created_at', 'DESC'))
            ->defaultSort(fn($query) => $query->orderByRaw("FIELD(status_transaksi , 'penawaran', 'pembayaran') DESC"))
            ->emptyStateHeading('Belum ada data! 🙁')
            ->filters([
                SelectFilter::make('status_transaksi')
                    ->label('Status Transaksi')
                    ->options([
                        'penawaran' => 'Proses Penawaran',
                        'pembayaran' => 'Proses Pembayaran',
                        'dibayar' => 'Dibayar',
                        'selesai' => 'Selesai',
                        'cancel' => 'Cancel',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('bukti_tf')
                    ->visible(fn(Transaction $record) => $record->bukti_tf !== null && $record->status_transaksi === 'pembayaran')
                    ->label('Bukti Pembayaran')
                    ->color(Color::Orange)
                    ->icon('heroicon-o-document-text')
                    ->form([
                        ComponentsActions::make([
                            ComponentsActionsAction::make('bukti_tf')
                                ->label('Lihat Bukti Pembayaran')
                                ->icon('heroicon-o-document-text')
                                ->url(fn(Transaction $record): string => url('storage', $record->bukti_tf))
                                ->openUrlInNewTab()
                                ->color(Color::Gray),
                        ])
                            ->alignCenter()
                            ->fullWidth()
                    ])
                    ->action(function (Transaction $record) {
                        $record->status_transaksi = 'dibayar';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-bell-alert')
                    ->modalIconColor('success')
                    ->modalSubmitActionLabel('Konfirmasi')
                    ->modalSubmitAction(
                        fn(\Filament\Actions\StaticAction $action) =>
                        $action->color('success')
                    )
                    ->modalDescription('Cek Bukti Pembayaran terlebih dulu!'),
                Tables\Actions\Action::make('tf_denda')
                    ->visible(fn(Transaction $record) => $record->tf_denda !== null && $record->status_transaksi === 'denda')
                    ->label('Bukti Pembayaran')
                    ->modalHeading('Bukti Pembayaran Denda')
                    ->color(Color::Red)
                    ->icon('heroicon-o-document-text')
                    ->form([
                        ComponentsActions::make([
                            ComponentsActionsAction::make('tf_denda')
                                ->label('Lihat Bukti Pembayaran Denda')
                                ->icon('heroicon-o-document-text')
                                ->url(fn(Transaction $record): string => url('storage', $record->tf_denda))
                                ->openUrlInNewTab()
                                ->color(Color::Gray),
                        ])
                            ->alignCenter()
                            ->fullWidth()
                    ])
                    ->action(function (Transaction $record) {
                        $record->status_transaksi = 'selesai';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->modalIcon('heroicon-o-bell-alert')
                    ->modalIconColor('success')
                    ->modalSubmitActionLabel('Konfirmasi')
                    ->modalSubmitAction(
                        fn(\Filament\Actions\StaticAction $action) =>
                        $action->color('success')
                    )
                    ->modalDescription('Cek Bukti Pembayaran Denda terlebih dulu!'),
                Tables\Actions\Action::make('penawaran')
                    ->mountUsing(fn(Forms\ComponentContainer $form, Transaction $record) => $form->fill([
                        'ppn' => 11,
                        'site' => $record->site,
                        'durasi_sewa' => Carbon::parse($record->tgl_sewa)->diffInDays(Carbon::parse($record->tgl_selesai)),
                    ]))
                    ->form([
                        Section::make('Rent Information')
                            ->schema([
                                Forms\Components\Select::make('genset_id')
                                    ->label('Genset')
                                    ->placeholder('Pilih Genset')
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $gs = Genset::where('id', $get('genset_id'))->first();

                                        $gs != null ? $set('harga', $gs->harga) : $set('harga', 0);
                                    })
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Genset wajib diisi.',
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->relationship(
                                        name: 'genset',
                                        modifyQueryUsing: function (Builder $query) {
                                            $query->where('status_genset', 'ready');
                                        },
                                    )
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')'),
                                Forms\Components\Select::make('sales_id')
                                    ->label('Sales')
                                    ->placeholder('Pilih Sales')
                                    ->native(false)
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Sales wajib diisi.',
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->relationship(
                                        name: 'sale',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: function (Builder $query) {
                                            $query->where('role', 'sales');
                                        },
                                    ),
                            ])->columns(2)
                            ->collapsible(),

                        Section::make('Mob Demob Information')
                            ->schema([
                                Select::make('jenis_mobil')
                                    ->native(false)
                                    ->label('Jenis Angkutan')
                                    ->options([
                                        'bak_terbuka' => 'Truck Bak Terbuka',
                                        'crane' => 'Truck Crane',
                                    ])
                                    ->live()
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('site')
                                    ->label('Lokasi Proyek')
                                    ->columnSpanFull(),
                                Select::make('jarak')
                                    ->native(false)
                                    ->label('Jarak')
                                    ->live()
                                    ->options([
                                        '50' => '0 KM - 50 KM',
                                        '100' => '50 KM - 100 KM',
                                        '>100' => '> 100 KM',
                                    ]),
                                Forms\Components\Placeholder::make('mob_demob_placheholder')
                                    ->label('Biaya Mob Demob')
                                    ->content(function (Get $get, Set $set) {

                                        $total =  0;

                                        if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '50') {
                                            $total = 2000000;
                                        } else if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '100') {
                                            $total = 3500000;
                                        } else if ($get('jenis_mobil') == 'bak_terbuka' && $get('jarak') == '>100') {
                                            $total = 8500000;
                                        } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '50') {
                                            $total = 3500000;
                                        } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '100') {
                                            $total = 8000000;
                                        } else if ($get('jenis_mobil') == 'crane' && $get('jarak') == '>100') {
                                            $total = 12500000;
                                        } else {
                                            $total = 0;
                                        }

                                        $set('mob_demob', $total);
                                        return Number::currency($total, 'IDR', 'ID');
                                    }),

                                Forms\Components\Hidden::make('mob_demob')
                                    ->dehydrated()
                                    ->default(0),
                                // TextInput::make('mob_demob')
                                //     ->label('Mob Demob')
                                //     ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                //     ->mask(RawJs::make('$money($input)'))
                                //     ->stripCharacters(',')
                                //     ->dehydrateStateUsing(fn($state) => floatval(str_replace(',', '', $state)))
                                //     ->numeric()
                                //     ->reactive()
                                //     ->live(onBlur: true)
                                //     ->default(0)
                                //     ->dehydrated()
                                //     ->prefix('Rp'),
                            ])
                            ->columns(2)
                            ->collapsible(),

                        Section::make('Price Information')
                            ->schema([
                                TextInput::make('harga')
                                    ->label('Harga Sewa (Perhari)')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Harga Sewa wajib diisi.',
                                    ])
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->dehydrateStateUsing(fn($state, Get $get) => floatval(str_replace(',', '', $state)) * $get('durasi_sewa'))
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->prefix('Rp'),

                                Toggle::make('operator')
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $get('operator') ? $set('biaya_operator', 100000) : $set('biaya_operator', 0);
                                    }),
                                TextInput::make('biaya_operator')
                                    ->label('Biaya Operator (Perhari)')
                                    ->hintIcon('heroicon-o-information-circle', tooltip: 'Optional')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->dehydrateStateUsing(fn($state, Get $get) => floatval(str_replace(',', '', $state)) * $get('durasi_sewa'))
                                    ->numeric()
                                    ->default(0)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->dehydrated()
                                    ->visible(fn(Get $get) => $get('operator'))
                                    ->prefix('Rp'),
                                TextInput::make('durasi_sewa')
                                    ->label('Durasi Sewa')
                                    ->live()
                                    ->numeric()
                                    ->validationMessages([
                                        'required' => 'Durasi Sewa wajib diisi.',
                                    ])
                                    ->required()
                                    ->suffix('Hari'),

                                Placeholder::make('sub_total_placheholder')
                                    ->label('Sub Total')
                                    ->content(function (Get $get, Set $set) {
                                        $total = 0;

                                        if ($get('harga') == null) {
                                            $set('harga', 0);
                                        } elseif ($get('mob_demob') == null) {
                                            $set('mob_demob', 0);
                                        } elseif ($get('biaya_operator') == null) {
                                            $set('biaya_operator', 0);
                                        }

                                        if (floatval(str_replace(',', '', $get('harga'))) > 0) {
                                            $total = (floatval(str_replace(',', '', $get('harga'))) * $get('durasi_sewa')) + floatval(str_replace(',', '', $get('mob_demob'))) + (floatval(str_replace(',', '', $get('biaya_operator'))) * $get('durasi_sewa'));
                                        }

                                        $set('sub_total', $total);
                                        return Number::currency($total, 'IDR', 'ID');
                                    }),

                                Hidden::make('sub_total')
                                    ->dehydrated()
                                    ->default(0),

                                TextInput::make('ppn')
                                    ->label('PPN')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'PPN wajib diisi.',
                                    ])
                                    ->validationMessages([
                                        'required' => 'PPN wajib diisi.',
                                    ])
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->dehydrated()
                                    ->suffix('%'),


                                Placeholder::make('grand_total_placheholder')
                                    ->label('Grand Total (Include PPN)')
                                    ->content(function (Get $get, Set $set) {
                                        $total = 0;
                                        if ($get('ppn') > 0) {
                                            $total = $get('sub_total') + $get('sub_total') * $get('ppn') / 100;
                                        }

                                        $set('grand_total', $total);
                                        return Number::currency($total, 'IDR', 'ID');
                                    }),

                                Hidden::make('grand_total')
                                    ->default(0),
                            ])
                            ->aside()
                            ->collapsible()
                    ])
                    ->action(function (Transaction $record, array $data) {
                        $record->genset_id = $data['genset_id'];
                        $record->harga = $data['harga'];
                        $record->mob_demob = $data['mob_demob'];
                        $record->biaya_operator = $data['operator'] ? $data['biaya_operator'] : 0;
                        $record->sub_total = $data['sub_total'];
                        $record->ppn = $data['ppn'];
                        $record->grand_total = $data['grand_total'];
                        $record->save();

                        $message = 'Halo Kak ' . $record->customer->name . ', Penawaran harga untuk ' . str()->title($record->subject) . ' Genset ' . $record->brand_engine . ' ' . $record->kapasitas . ' sudah dikirim! 😁. Silakan Cek Penawaran dengan Order ID #' . $record->order_id;
                        $no_telp = $record->customer->no_telp;
                        $token = 'jVT18@D7koZiQkm3wE4z';

                        $curl = curl_init();

                        curl_setopt_array(
                            $curl,
                            array(
                                CURLOPT_URL => 'https://api.fonnte.com/send',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => array('target' => $no_telp, 'message' => $message),
                                CURLOPT_HTTPHEADER => array(
                                    'Authorization: ' . $token
                                ),
                            )
                        );

                        $response = curl_exec($curl);

                        curl_close($curl);

                        Notification::make()
                            ->title('Penawaran Berhasil dikirim!')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Penawaran Harga')
                    ->modalSubmitAction(
                        fn(\Filament\Actions\StaticAction $action) =>
                        $action->color('success')
                    )
                    ->label('Buat Penawaran')
                    ->icon('heroicon-o-document-plus')
                    ->color(Color::Indigo)
                    ->visible(fn(Transaction $record) => $record->genset_id == null),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_penawaran')
                        ->label('Penawaran')
                        ->visible(fn(Transaction $record) => $record->genset_id != null)
                        ->icon('heroicon-o-document-text')
                        ->color(Color::Rose)
                        ->url(fn(Transaction $record) => route('pdf.penawaran', $record->order_id))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('view_invoice')
                        ->label('Invoice')
                        ->visible(fn(Transaction $record) => $record->genset_id != null)
                        ->icon('heroicon-o-document-text')
                        ->color(Color::Lime)
                        ->url(fn(Transaction $record) => route('pdf.invoice', $record->order_id))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('view_denda')
                        ->label('Invoice Denda')
                        ->visible(fn(Transaction $record) => $record->overtime != 0)
                        ->icon('heroicon-o-document-text')
                        ->color(Color::Slate)
                        ->url(fn(Transaction $record) => route('pdf.denda', $record->order_id))
                        ->openUrlInNewTab(),
                    Tables\Actions\EditAction::make()
                        ->modalHeading('Edit Penawaran')
                        ->color(Color::Indigo),
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Transaksi')
                        ->color(Color::Orange),
                    Tables\Actions\DeleteAction::make(),
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
                ComponentsSection::make('Informasi Penawaran')
                    ->schema([
                        TextEntry::make('order_id')
                            ->label('Order ID'),
                        TextEntry::make('subject')
                            ->formatStateUsing(fn(string $state): string => str()->title($state) . ' Genset'),
                        TextEntry::make('status_transaksi')
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'penawaran' => 'Proses Penawaran',
                                'pembayaran' => 'Proses Pembayaran',
                                'dibayar' => 'Dibayar',
                                'denda' => 'Denda',
                                'selesai' => 'Selesai',
                                'cancel' => 'Cancel',
                            })
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'penawaran' => 'warning',
                                'pembayaran' => 'primary',
                                'dibayar' => 'success',
                                'denda' => 'danger',
                                'selesai' => 'success',
                                'cancel' => 'danger',
                            })
                            ->icon(fn(string $state): string => match ($state) {
                                'penawaran' => 'heroicon-o-arrow-path',
                                'pembayaran' => 'heroicon-o-banknotes',
                                'dibayar' => 'heroicon-o-check-badge',
                                'denda' => 'heroicon-o-banknotes',
                                'selesai' => 'heroicon-o-check-badge',
                                'cancel' => 'heroicon-o-x-mark',
                            })
                            ->label('Status'),
                        TextEntry::make('kapasitas')
                            ->getStateUsing(fn(Model $record) => ($record->kapasitas ? $record->kapasitas : $record->genset->kapasitas) . ' KVA'),
                        TextEntry::make('durasi_sewa')
                            ->visible(fn(Transaction $record) => $record->durasi_sewa !== null)
                            ->suffix(' Hari'),
                        IconEntry::make('operator')
                            ->icon(fn(string $state): string => match ($state) {
                                '0' => 'heroicon-o-x-circle',
                                '1' => 'heroicon-o-check-circle',
                            })
                            ->color(fn(string $state): string => match ($state) {
                                '0' => 'danger',
                                '1' => 'success',
                                default => 'gray',
                            }),
                        TextEntry::make('customer.name')
                            ->label('Customer')
                            ->formatStateUsing(fn(string $state): string => str()->title($state)),
                        TextEntry::make('customer.perusahaan')
                            ->label('Perusahaan')
                            ->visible(fn(Transaction $record) => $record->perusahaan !== null),
                        TextEntry::make('customer.email')
                            ->label('Email'),
                        TextEntry::make('customer.no_telp')
                            ->label('No Telp'),
                        TextEntry::make('site')
                            ->label('Lokasi Proyek'),
                        Actions::make([
                            ActionsAction::make('penawaran')
                                ->visible(fn(Transaction $record) => $record->genset_id != null)
                                ->label('Lihat Penawaran')
                                ->icon('heroicon-o-document-text')
                                ->url(fn(Transaction $record) => route('pdf.penawaran', $record->order_id))
                                ->openUrlInNewTab()
                                ->color(Color::Rose),
                        ]),
                        TextEntry::make('keterangan')
                            ->visible(fn(Transaction $record) => $record->keterangan != null),

                    ])->columns(3)->collapsible(),
                ComponentsSection::make('Detail Harga')
                    ->schema([
                        TextEntry::make('harga')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->harga, 'IDR', 'id')),
                        TextEntry::make('mob_demob')
                            ->label('Mob Demob')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->mob_demob, 'IDR', 'id')),
                        TextEntry::make('biaya_operator')
                            ->label('Biaya Operator')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->biaya_operator, 'IDR', 'id')),
                        TextEntry::make('sub_total')
                            ->label('Sub Total')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->sub_total, 'IDR', 'id')),
                        TextEntry::make('ppn')
                            ->label('PPN')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->sub_total * $record->ppn / 100, 'IDR', 'id')),
                        TextEntry::make('denda')
                            ->label('Denda Overtime')
                            ->visible(fn(Transaction $record) => $record->denda !== null)
                            ->formatStateUsing(fn(Transaction $record) => $record->denda ? Number::currency($record->denda, 'IDR', 'id') : Number::currency(0, 'IDR', 'id')),
                        TextEntry::make('grand_total')
                            ->label('Grand Total')
                            ->formatStateUsing(fn(Transaction $record) => Number::currency($record->grand_total, 'IDR', 'id')),
                        Actions::make([
                            ActionsAction::make('bukti_tf')
                                ->visible(fn(Transaction $record) => $record->bukti_tf !== null)
                                ->label('Bukti Pembayaran')
                                ->icon('heroicon-o-document-text')
                                ->url(fn(Transaction $record): string => url('storage', $record->bukti_tf))
                                ->openUrlInNewTab()
                                ->color(Color::Green),
                        ])
                            ->columnSpanFull(),
                    ])
                    ->visible(fn(Transaction $record) => $record->genset_id)
                    ->columns(3)
                    ->collapsible()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_transaksi', '!=', 'cancel')
            ->where('status_transaksi', '!=', 'dibayar')
            ->where('status_transaksi', '!=', 'selesai')
            ->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}
