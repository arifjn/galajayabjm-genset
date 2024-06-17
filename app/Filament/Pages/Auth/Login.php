<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseAuth
{
    public function getTitle(): string|Htmlable
    {
        return __('Admin Login');
    }

    public function getHeading(): string|Htmlable
    {
        return __('Admin Login');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('Login'))
            ->submit('authenticate');
    }
}
