<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyProfilePage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $customer_id;
    public $name;
    public $tempat_lahir;
    public $tgl_lahir;
    public $no_telp;
    public $email;
    public $alamat;
    public $tipe_customer;
    public $perusahaan;
    public $password;
    public $password_confirmation;
    public $profile_img;

    public function mount($customer_id)
    {
        $customer = Customer::find($customer_id);

        $this->customer_id = $customer_id;
        $this->name = $customer->name;
        $this->tempat_lahir = $customer->tempat_lahir;
        $this->tgl_lahir = $customer->tgl_lahir->format('Y-m-d');
        $this->no_telp = $customer->no_telp;
        $this->email = $customer->email;
        $this->alamat = $customer->alamat;
        $this->tipe_customer = $customer->tipe_customer;
        $this->perusahaan = $customer->perusahaan;
        $this->profile_img = $customer->profile_img;
    }

    public function update()
    {
        $customer = Customer::where('id', $this->customer_id)->firstOrFail();

        $this->validate([
            'name' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'required|min:6',
            'email' => 'required|email|unique:customers,email,' . $this->customer_id,
            'alamat' => 'required',
            'tipe_customer' => 'required',
            'password' => 'confirmed',
        ]);
        if ($this->profile_img != $customer->profile_img) {
            //check if image is uploaded
            //upload new image
            $image = $this->profile_img;
            $image->storeAs('public/customer/', $image->hashName());
            $img = 'customer/' . $image->hashName();

            //delete old image
            Storage::delete('public/customer/' . $customer->profile_img);

            if ($this->password == null) {
                // no update pw
                $customer->update(
                    [
                        'name' => $this->name,
                        'tempat_lahir' => $this->tempat_lahir,
                        'tgl_lahir' => $this->tgl_lahir,
                        'no_telp' => $this->no_telp,
                        'email' => $this->email,
                        'alamat' => $this->alamat,
                        'tipe_customer' => $this->tipe_customer,
                        'perusahaan' => $this->perusahaan,
                        'profile_img' => $img,
                    ]
                );
            } else {
                // update pw
                $customer->update([
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
            }
        } else {
            // update profile without image
            if ($this->password == null) {
                // no update pw
                $customer->update(
                    [
                        'name' => $this->name,
                        'tempat_lahir' => $this->tempat_lahir,
                        'tgl_lahir' => $this->tgl_lahir,
                        'no_telp' => $this->no_telp,
                        'email' => $this->email,
                        'alamat' => $this->alamat,
                        'tipe_customer' => $this->tipe_customer,
                        'perusahaan' => $this->perusahaan,
                    ]
                );
            } else {
                // update pw
                $customer->update(
                    [
                        'name' => $this->name,
                        'tempat_lahir' => $this->tempat_lahir,
                        'tgl_lahir' => $this->tgl_lahir,
                        'no_telp' => $this->no_telp,
                        'email' => $this->email,
                        'alamat' => $this->alamat,
                        'tipe_customer' => $this->tipe_customer,
                        'perusahaan' => $this->perusahaan,
                        'password' => Hash::make($this->password),
                    ]
                );
            }
        }

        $this->flash('success', 'Success!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Your profile has been updated!',
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.my-profile-page', [
            'profile' => Customer::where('id', $this->customer_id)->firstOrFail(),
        ]);
    }
}
