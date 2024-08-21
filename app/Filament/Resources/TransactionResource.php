<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Genset;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Actions as ComponentsActions;
use Filament\Forms\Components\Actions\Action as ComponentsActionsAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action as ActionsAction;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
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

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $slug = 'transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('genset_id')
                    ->label('Genset')
                    ->placeholder('Pilih Genset')
                    ->native(false)
                    ->relationship(
                        name: 'genset',
                        modifyQueryUsing: function (Builder $query) {
                            $query->where('status_genset', 'ready');
                        },
                    )
                    ->columnSpanFull()
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')'),
                Section::make('Price Information')
                    ->schema([
                        TextInput::make('harga')
                            ->autofocus()
                            ->numeric()
                            ->validationMessages([
                                'required' => 'Harga wajib diisi.',
                            ])
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->reactive()
                            ->live(onBlur: true)
                            ->prefix('Rp'),
                        TextInput::make('mob_demob')
                            ->label('Mob Demob')
                            ->numeric()
                            ->reactive()
                            ->live(onBlur: true)
                            ->default(0)
                            ->dehydrated()
                            ->prefix('Rp'),
                        TextInput::make('biaya_operator')
                            ->label('Biaya Operator')
                            ->numeric()
                            ->default(0)
                            ->reactive()
                            ->live(onBlur: true)
                            ->dehydrated()
                            ->prefix('Rp'),
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

                                if ($get('harga') > 0) {
                                    $total = $get('harga') + $get('mob_demob') + $get('biaya_operator');
                                }

                                $set('sub_total', $total);
                                return Number::currency($total, 'IDR', 'ID');
                            })
                            ->columnSpanFull(),

                        Hidden::make('sub_total')
                            ->dehydrated()
                            ->default(0),
                        TextInput::make('ppn')
                            ->label('PPN')
                            ->validationMessages([
                                'required' => 'PPN wajib diisi.',
                            ])
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->dehydrated()
                            ->suffix('%'),
                        Placeholder::make('grand_total_placheholder')
                            ->label('Grand Total')
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
                    ->columns(3)
                    ->collapsible()
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
                TextColumn::make('brand_engine')
                    ->label('Brand Engine')
                    ->formatStateUsing(fn(string $state): string => str()->upper($state))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kapasitas')
                    ->searchable()
                    ->sortable(),
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
                        'selesai' => 'success',
                        'cancel' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'penawaran' => 'heroicon-o-arrow-path',
                        'pembayaran' => 'heroicon-o-banknotes',
                        'dibayar' => 'heroicon-o-check-badge',
                        'selesai' => 'heroicon-o-check-badge',
                        'cancel' => 'heroicon-o-x-mark',
                    }),
            ])
            ->defaultSort('status_transaksi', 'DESC')
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
                Tables\Actions\Action::make('penawaran')
                    ->mountUsing(fn(Forms\ComponentContainer $form, Transaction $record) => $form->fill([
                        'ppn' => 11,
                    ]))
                    ->form([
                        Forms\Components\Select::make('genset_id')
                            ->label('Genset')
                            ->placeholder('Pilih Genset')
                            ->native(false)
                            ->relationship(
                                name: 'genset',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('status_genset', 'ready');
                                },
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => str()->upper($record->brand_engine) . ' ' . $record->kapasitas . " KVA" . ' (' . $record->no_genset . ')'),
                        Forms\Components\Select::make('sales_id')
                            ->label('Sales')
                            ->placeholder('Pilih Pilih')
                            ->native(false)
                            ->relationship(
                                name: 'sale',
                                titleAttribute: 'name',
                                modifyQueryUsing: function (Builder $query) {
                                    $query->where('role', 'sales');
                                },
                            ),
                        Section::make('Price Information')
                            ->schema([
                                TextInput::make('harga')
                                    ->autofocus()
                                    ->numeric()
                                    ->validationMessages([
                                        'required' => 'Harga wajib diisi.',
                                    ])
                                    ->required()
                                    ->default(0)
                                    ->minValue(0)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->prefix('Rp'),
                                TextInput::make('mob_demob')
                                    ->label('Mob Demob')
                                    ->numeric()
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->default(0)
                                    ->dehydrated()
                                    ->prefix('Rp'),
                                TextInput::make('biaya_operator')
                                    ->label('Biaya Operator')
                                    ->numeric()
                                    ->default(0)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->dehydrated()
                                    ->prefix('Rp'),
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

                                        if ($get('harga') > 0) {
                                            $total = $get('harga') + $get('mob_demob') + $get('biaya_operator');
                                        }

                                        $set('sub_total', $total);
                                        return Number::currency($total, 'IDR', 'ID');
                                    })
                                    ->columnSpanFull(),

                                Hidden::make('sub_total')
                                    ->dehydrated()
                                    ->default(0),
                                TextInput::make('ppn')
                                    ->label('PPN')
                                    ->validationMessages([
                                        'required' => 'PPN wajib diisi.',
                                    ])
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->dehydrated()
                                    ->suffix('%'),
                                Placeholder::make('grand_total_placheholder')
                                    ->label('Grand Total')
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
                            ->columns(3)
                            ->collapsible()
                    ])
                    ->action(function (Transaction $record, array $data) {
                        $record->genset_id = $data['genset_id'];
                        $record->harga = $data['harga'];
                        $record->mob_demob = $data['mob_demob'];
                        $record->biaya_operator = $data['biaya_operator'];
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
                    Tables\Actions\EditAction::make()
                        ->color(Color::Indigo),
                    Tables\Actions\ViewAction::make()
                        ->modalHeading('Lihat Transaksi')
                        ->color(Color::Orange),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('pdf-order')
                    ->label('Download PDF')
                    ->color(Color::Rose)
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function ($records) {
                        $pdf = Pdf::loadView('pdf.order', ['orders' => $records])->setPaper('a4', 'landscape');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'laporan-transaksi.pdf');
                    })
                    ->deselectRecordsAfterCompletion(),
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
                                'selesai' => 'Selesai',
                                'cancel' => 'Cancel',
                            })
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'penawaran' => 'warning',
                                'pembayaran' => 'primary',
                                'dibayar' => 'success',
                                'selesai' => 'success',
                                'cancel' => 'danger',
                            })
                            ->icon(fn(string $state): string => match ($state) {
                                'penawaran' => 'heroicon-o-arrow-path',
                                'pembayaran' => 'heroicon-o-banknotes',
                                'dibayar' => 'heroicon-o-check-badge',
                                'selesai' => 'heroicon-o-check-badge',
                                'cancel' => 'heroicon-o-x-mark',
                            })
                            ->label('Status'),
                        TextEntry::make('brand_engine')
                            ->label('Brand Engine'),
                        TextEntry::make('kapasitas'),
                        TextEntry::make('durasi_sewa')
                            ->visible(fn(Transaction $record) => $record->durasi_sewa !== null)
                            ->suffix(' Hari'),
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
                        TextEntry::make('keterangan')
                            ->visible(fn(Transaction $record) => $record->keterangan != null)
                            ->columnSpan(2),
                        Actions::make([
                            ActionsAction::make('penawaran')
                                ->visible(fn(Transaction $record) => $record->genset_id != null)
                                ->label('Lihat Penawaran')
                                ->icon('heroicon-o-document-text')
                                ->url(fn(Transaction $record) => route('pdf.penawaran', $record->order_id))
                                ->openUrlInNewTab()
                                ->color(Color::Rose),
                        ])
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
                            ->suffix('%'),
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
                    ])->columns(3)->collapsible()
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
