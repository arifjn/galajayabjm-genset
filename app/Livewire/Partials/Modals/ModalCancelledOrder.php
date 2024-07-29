<?php

namespace App\Livewire\Partials\Modals;

use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ModalCancelledOrder extends Component
{
    use LivewireAlert;

    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        return view('livewire.partials.modals.modal-cancelled-order');
    }

    public function cancel()
    {
        $order = Transaction::where('order_id', $this->order_id)->firstOrFail();

        $order->update([
            'status_transaksi' => 'cancel',
        ]);

        $this->flash('error', 'Cancelled!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Your order has been cancelled!',
            'timerProgressBar' => true,
        ]);

        return redirect()->route('cancel', [auth()->guard('customer')->user()->id, $order->order_id]);
    }
}
