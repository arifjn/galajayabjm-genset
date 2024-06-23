<?php

namespace App\Livewire\Partials;

use App\Models\Customer;
use Livewire\Component;

class ModalQuotation extends Component
{
    public $subject = '', $durasi_sewa, $name, $perusahaan, $alamat, $site, $email, $no_telp, $kapasitas = '', $brand_engine = '', $keterangan;

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

    public function save()
    {
        $this->validate([
            'subject' => 'required',
            'durasi_sewa' => 'numeric',
            'name' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required',
            'kapasitas' => 'required',
            'brand_engine' => 'required',
        ]);
    }

    public function render()
    {
        return view('livewire.partials.modal-quotation');
    }
}
