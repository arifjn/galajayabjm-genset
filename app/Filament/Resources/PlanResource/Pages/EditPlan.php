<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Filament\Resources\PlanResource;
use App\Models\Plan;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlan extends EditRecord
{
    protected static string $resource = PlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Plan $record) {
                    if ($record->order_id) {
                        $order = Transaction::find($record->order_id);
                        $order->status_transaksi = 'dibayar';
                        $order->save();
                    }
                }),
        ];
    }

    // showing data field in edit page
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['order_id'] = $this->record->transaction?->customer->name;
        return $data;
    }
}
