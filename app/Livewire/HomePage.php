<?php

namespace App\Livewire;

use App\Models\Genset;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\Url;

class HomePage extends Component
{
    public $input_watt;

    public $search = '';

    public function searchBox()
    {
        return redirect()->to('/products?search=' . $this->search);
    }

    public function render()
    {
        return view('livewire.home-page', [
            'products' => Genset::where('status_genset', 'ready')->paginate(4),
        ]);
    }
}
