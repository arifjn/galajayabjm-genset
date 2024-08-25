<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Forms\ComponentContainer;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ManageTransactions extends ManageRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah')
                ->icon('heroicon-o-plus')
                ->modalHeading('Buat Penawaran')
                ->mutateFormDataUsing(
                    function (array $data, Model $record): array {
                        $order_id = IdGenerator::generate(['table' => 'transactions', 'field' => 'order_id', 'length' => 12, 'prefix' => 'GJ-' . date('ymd')]);

                        $data['subject'] = 'sewa';
                        // $data['site'] = $data['site'] == null ? $record->customer->alamat : $data['site'];
                        $data['order_id'] = $order_id;
                        $data['status_transaksi'] = 'penawaran';

                        return $data;
                    }
                )
                ->mountUsing(fn(ComponentContainer $form) => $form->fill([
                    'ppn' => 11,
                ])),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Transaksi';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TransactionResource\Widgets\TransactionOverview::class,
        ];
    }
}
