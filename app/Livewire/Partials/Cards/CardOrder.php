<?php

namespace App\Livewire\Partials\Cards;

use Livewire\Component;

class CardOrder extends Component
{
    public $order;
    public $plan;

    public function render()
    {
        return view('livewire.partials.cards.card-order');
    }
}
