<?php

namespace App\Livewire\Partials\Modals;

use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ModalRevisiOrder extends Component
{
    use LivewireAlert;

    public $order_id, $keterangan;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function save()
    {
        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        $order->update([
            'keterangan' => $this->keterangan,
        ]);

        $this->flash('success', 'Revisi Penawaran!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Permintaan revisi penawaran harga berhasil dikirim!',
            'timerProgressBar' => true,
        ]);

        return redirect()->to(route('order.show', [auth()->guard('customer')->user()->id, $this->order_id]));
    }

    public function render()
    {
        return view('livewire.partials.modals.modal-revisi-order');
    }
}
