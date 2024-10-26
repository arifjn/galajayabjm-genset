<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyOrderDetailPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $order_id;
    public $bukti_tf;
    public $tf_denda;

    public $currentStep = 1;

    public function mount($order_id)
    {
        $this->order_id = $order_id;

        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        if ($order->status_transaksi == 'pembayaran') {
            $this->currentStep = 2;
        } elseif ($order->status_transaksi == 'dibayar' || $order->status_transaksi == 'denda' || $order->status_transaksi == 'delivery' || $order->status_transaksi == 'selesai') {
            $this->currentStep = 3;
        } else {
            $this->currentStep = 1;
        }
    }

    public function render()
    {
        return view('livewire.my-order-detail-page', [
            'order' => Transaction::where('order_id', $this->order_id)
                ->whereHas('customer', function ($q) {
                    $q->where('id', auth()->guard('customer')->user()->id);
                })
                ->firstOrFail(),
            'plan' => Plan::where('order_id', $this->order_id)->first(),
            'services' => Plan::where('order_id', $this->order_id)->where('jobdesk', 'service')->get(),
        ]);
    }

    // stepper
    public function firstStepSubmit()
    {
        $this->currentStep = 2;
    }

    // public function secondStepSubmit()
    // {
    //     $this->currentStep = 3;
    // }

    public function backStep($step)
    {
        $this->currentStep = $step;
    }
    // end stepper

    public function save()
    {
        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        $this->validate([
            'bukti_tf' => 'mimes:pdf|max:20000',
        ]);

        $file = "";

        //upload image
        if ($this->bukti_tf == null) {
            $file = null;
        } else {
            $file = $this->bukti_tf;
            $file->storeAs('public/pdf-buktibayar/', $file->hashName());
            $file_bukti = 'pdf-buktibayar/' . $file->hashName();
        }

        $order->update([
            'bukti_tf' => $file_bukti
        ]);

        $this->flash('success', 'Success!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Bukti Pembayaran berhasil dikirim!',
            'timerProgressBar' => true,
        ]);

        return redirect()->to(route('order.show', [auth()->guard('customer')->user()->id, $this->order_id]));
    }

    public function save_denda()
    {
        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        $this->validate([
            'tf_denda' => 'mimes:pdf|max:20000',
        ]);

        $file = "";

        //upload image
        if ($this->tf_denda == null) {
            $file = null;
        } else {
            $file = $this->tf_denda;
            $file->storeAs('public/pdf-buktibayar_denda/', $file->hashName());
            $file_bukti = 'pdf-buktibayar_denda/' . $file->hashName();
        }

        $order->update([
            'tf_denda' => $file_bukti
        ]);

        $this->flash('success', 'Success!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Bukti Pembayaran Denda berhasil dikirim!',
            'timerProgressBar' => true,
        ]);

        return redirect()->to(route('order.show', [auth()->guard('customer')->user()->id, $this->order_id]));
    }
}
