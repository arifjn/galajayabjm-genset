<?php

namespace App\Livewire\Partials\Modals;

use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Genset;
use App\Models\Transaction;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalQuotation extends Component
{
    use LivewireAlert;

    public $customer_id;
    public $subject = '';
    public $durasi_sewa;
    public $site;
    // $name, $perusahaan,
    // $alamat,
    // $email,
    // $no_telp,
    public $kapasitas = '';
    public $brand_engine = '';
    public $keterangan;
    public  $validateSite = true;

    public function save()
    {
        $this->validate([
            'subject' => 'required',
            'kapasitas' => 'required',
            'brand_engine' => 'required',
        ]);

        $site = $this->site;

        if ($site == '') {
            $customer = Customer::find(auth()->guard('customer')->user()->id);
            $site = $customer->alamat;
        }

        $order_id = IdGenerator::generate(['table' => 'transactions', 'field' => 'order_id', 'length' => 12, 'prefix' => 'GJ-' . date('ymd')]);

        // save to db
        Transaction::create([
            'order_id' => $order_id,
            'customer_id' => auth()->guard('customer')->user()->id,
            'subject' => $this->subject,
            'durasi_sewa' => $this->durasi_sewa,
            'site' => $site,
            'kapasitas' => $this->kapasitas,
            'brand_engine' => $this->brand_engine,
            'keterangan' => $this->keterangan,
            'status_transaksi' => 'penawaran',
        ]);

        $this->flash('success', 'Success!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Permintaan Penawaran Berhasil dikirim!',
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.partials.modals.modal-quotation');
    }
}
