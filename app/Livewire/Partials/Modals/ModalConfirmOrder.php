<?php

namespace App\Livewire\Partials\Modals;

use App\Models\Transaction;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class ModalConfirmOrder extends Component
{
    use LivewireAlert;

    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        return view('livewire.partials.modals.modal-confirm-order');
    }

    public function confirm()
    {
        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        $order->update([
            'status_transaksi' => 'pembayaran',
        ]);

        $this->flash('success', 'Confirmation!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Your order has been confirmed!',
            'timerProgressBar' => true,
        ]);

        return redirect()->to(route('order.show', [auth()->guard('customer')->user()->id, $this->order_id]));
    }
}
