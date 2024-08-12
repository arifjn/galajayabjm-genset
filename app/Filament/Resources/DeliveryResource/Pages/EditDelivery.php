<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use App\Models\Genset;
use App\Models\GensetPlan;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class EditDelivery extends EditRecord
{
    protected static string $resource = DeliveryResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Jobdesk';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Plan $record) {
                    if ($record->gensets) {
                        foreach ($record->gensets as $genset) {
                            $gs = Genset::find($genset->id);
                            $gs->status_genset = 'ready';
                            $gs->save();
                        }
                    }
                    if ($record->users) {
                        foreach ($record->users as $user) {
                            $u = User::find($user->id);
                            $u->status = 'tersedia';
                            $u->save();
                        }
                    }
                    if ($record->operator_id) {
                        $u = User::find($record->operator_id);
                        $u->status = 'tersedia';
                        $u->save();
                    }
                    $record->gensets()->detach();
                    $record->users()->detach();
                }),
        ];
    }
}
