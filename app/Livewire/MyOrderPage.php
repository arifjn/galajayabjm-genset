<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class MyOrderPage extends Component
{
    public function render()
    {
        return view('livewire.my-order-page', [
            'orders' => Transaction::orderByRaw("FIELD(status_transaksi, 'penawaran', 'pembayaran', 'delivery','success', 'cancel') ASC")
                ->whereHas('customer', function ($q) {
                    $q->where('id', auth()->guard('customer')->user()->id);
                })
                ->paginate(5),
        ]);
    }
}
