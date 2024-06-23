<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public $name;
    public $tempat_lahir;
    public $tgl_lahir;
    public $no_telp;
    public $email;
    public $alamat;
    public $tipe_customer = '';
    public $perusahaan;
    public $password;
    public $password_confirmation;
    public $profile_img;

    // register customer
    public function save()
    {
        $this->validate([
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'required|min:6',
            'email' => 'required|email|unique:customers',
            'alamat' => 'required',
            'tipe_customer' => 'required',
            'perusahaan' => 'nullable',
            'password' => 'required|confirmed|min:6',
            'profile_img' => 'image|nullable',
        ]);

        $img = "";

        //upload image
        if ($this->profile_img == null) {
            $img = null;
        } else {
            $image = $this->profile_img;
            $image->storeAs('public/customer/', $image->hashName());
            $img = 'customer/' . $image->hashName();
        }

        // save to db
        $customer = Customer::create([
            'name' => $this->name,
            'tempat_lahir' => $this->tempat_lahir,
            'tgl_lahir' => $this->tgl_lahir,
            'no_telp' => $this->no_telp,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'tipe_customer' => $this->tipe_customer,
            'perusahaan' => $this->perusahaan,
            'password' => Hash::make($this->password),
            'profile_img' => $img,
        ]);

        // login customer
        auth()->guard('customer')->login($customer);

        // redirect to homepage
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
