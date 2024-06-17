<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Url;
use Livewire\Component;

class ResetPasswordPage extends Component
{
    public $token;
    #[Url()]
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function save()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('customers')->reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function (Customer $customer, string $password) {
            $password = $this->password;
            $customer->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(str()->random(60));
            $customer->save();
            event(new PasswordReset($customer));
        });

        return $status === Password::PASSWORD_RESET ? redirect('/login') : session()->flash('error', 'Something went wrong!');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
