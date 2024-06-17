<?php

namespace App\Livewire;

use App\Models\Genset;
use Livewire\Component;

class DetailProductPage extends Component
{
    public $no_genset;

    public function mount($no_genset)
    {
        $this->no_genset = $no_genset;
    }

    public function render()
    {
        return view('livewire.detail-product-page', [
            'genset' => Genset::where('no_genset', $this->no_genset)->first(),
        ]);
    }
}
