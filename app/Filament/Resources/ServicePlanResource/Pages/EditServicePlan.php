<?php

namespace App\Filament\Resources\ServicePlanResource\Pages;

use App\Filament\Resources\ServicePlanResource;
use App\Models\Plan;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditServicePlan extends EditRecord
{
    protected static string $resource = ServicePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Plan $record) {
                    if ($record->users) {
                        foreach ($record->users as $user) {
                            $u = User::find($user->id);
                            $u->status = 'tersedia';
                            $u->save();
                        }
                    }
                    $record->gensets()->detach();
                    $record->users()->detach();
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return 'Edit Jadwal Service';
    }

    public function getBreadcrumb(): string
    {
        return 'Edit';
    }
}
