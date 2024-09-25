<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;


class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Pendapatan';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }


    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create($data);

        $transaction = Transaction::find($record->transaction_id);

        $transaction->status_transaksi = 'selesai';
        $transaction->save();

        return $record;
    }
}
