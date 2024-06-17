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
        // $productsQuery = Genset::query()->where('status_genset', 'ready');
        // if (!empty($this->search)) {
        //     $productsQuery
        //         ->where('brand_engine', 'like', '%' . $this->search . '%')
        //         ->orWhere('kapasitas', 'like', '%' . $this->search . '%')
        //         ->orWhere(DB::raw("CONCAT(`brand_engine`, ' ', `kapasitas`)"), 'LIKE', "%" . $this->search . "%");
        // }
        // dd($productsQuery);
        return redirect()->to('/products?search=' . $this->search);
        // return redirect()->to('/products')->with([
        //     'products' => $productsQuery->paginate(9),
        // ]);
    }

    public function render()
    {
        return view('livewire.home-page', [
            'products' => Genset::query()->where('status_genset', 'ready')->paginate(4),
        ]);
    }
}
