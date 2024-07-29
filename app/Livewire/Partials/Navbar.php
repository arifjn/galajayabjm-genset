<?php

namespace App\Livewire\Partials;

use App\Models\Transaction;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        $orders = [];

        if (auth()->guard('customer')->user()) {
            $orders = Transaction::query()->where('status_transaksi', 'penawaran')->whereHas('customer', fn ($q) => $q->where('id', auth()->guard('customer')->user()->id))->get();
        }
        return view('livewire.partials.navbar', [
            'orders' => $orders,
        ]);
    }
}
