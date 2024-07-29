<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Filament\Resources\PlanResource;
use App\Models\Genset;
use App\Models\Transaction;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreatePlan extends CreateRecord
{
    protected static string $resource = PlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Plan Job';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data';
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create($data);

        if ($record->order_id) {
            $order = Transaction::find($record->order_id);
            $order->status_transaksi = 'delivery';
            $order->save();
        }

        return $record;
    }
}
