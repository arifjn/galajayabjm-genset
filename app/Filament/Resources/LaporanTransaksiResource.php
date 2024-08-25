<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanTransaksiResource\Pages;
use App\Filament\Resources\LaporanTransaksiResource\RelationManagers;
use App\Models\LaporanTransaksi;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
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
use stdClass;

class LaporanTransaksiResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Transaksi';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'laporan-transaksi';

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
                //
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLaporanTransaksis::route('/'),
        ];
    }
}
