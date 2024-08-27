<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransactionResource::getEloquentQuery()
                    ->where('status_transaksi', 'penawaran')
                    ->orWhere('status_transaksi', 'pembayaran')
            )
            ->heading('Permintaan Penawaran Terbaru')
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
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
            ->emptyStateHeading('Belum ada data! 🙁');
        // ->actions([
        //     Tables\Actions\Action::make('View Order')
        //         ->url(fn(Transaction $record): string => Transaction::getUrl('view', ['record' => $record]))
        //         ->color('info')
        //         ->icon('heroicon-m-eye'),
        // ]);
    }
}
