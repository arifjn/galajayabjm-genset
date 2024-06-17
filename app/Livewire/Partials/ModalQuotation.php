<?php

namespace App\Livewire\Partials;

use App\Models\Customer;
use Livewire\Component;

class ModalQuotation extends Component
{
    public $name, $perusahaan, $alamat, $email, $no_telp;

    public function mount()
    {
        if (auth()->guard('customer')->user()) {
            $customer = Customer::find(auth()->guard('customer')->user()->id);

            $this->name = $customer->name;
            $this->perusahaan = $customer->perusahaan ? $customer->perusahaan : '';
            $this->alamat = $customer->alamat;
            $this->email = $customer->email;
            $this->no_telp = $customer->no_telp;
        }
    }

    public function render()
    {
        return view('livewire.partials.modal-quotation');
    }
}
