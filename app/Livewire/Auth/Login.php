<?php

namespace App\Livewire\Auth;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{

    use LivewireAlert;

    public $email, $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|min:6',
        ]);

        if (!auth()->guard('customer')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            session()->flash('error', 'Invalid Credentials!');
            return;
        }

        $this->flash('success', 'Success!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Login was successfully!',
            'timerProgressBar' => true,
        ]);

        // return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
