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
    public $kapasitas = '';
    public $tgl_sewa;
    public $tgl_selesai;
    public $operator = 0;
    public $keterangan;
    public  $validateSite = true;

    public function save()
    {
        $this->validate([
            'subject' => 'required',
            'kapasitas' => 'required',
            'tgl_sewa' => 'required',
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
            'tgl_sewa' => $this->tgl_sewa,
            'tgl_selesai' => $this->tgl_selesai,
            'operator' => $this->operator,
            'site' => $site,
            'kapasitas' => $this->kapasitas,
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
