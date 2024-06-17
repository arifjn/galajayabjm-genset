<?php

namespace App\Livewire;

use App\Models\Genset;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $selected_brand_engine = '';

    #[Url]
    public $capacity_range_first = 0;

    #[Url]
    public $capacity_range_last = 0;

    #[Url]
    public $sort = 'latest';

    public function render()
    {
        $productsQuery = Genset::query()->where('status_genset', 'ready');

        if (!empty($this->search)) {
            $productsQuery
                ->where('brand_engine', 'like', '%' . $this->search . '%')
                ->orWhere('kapasitas', 'like', '%' . $this->search . '%')
                ->orWhere(DB::raw("CONCAT('genset ', `brand_engine`, ' ', `kapasitas`, ' kva')"), 'LIKE', "%" . $this->search . "%");
        }

        if (!empty($this->selected_brand_engine)) {
            $productsQuery->where('brand_engine', $this->selected_brand_engine);
        }

        if ($this->capacity_range_first) {
            $productsQuery->whereBetween('kapasitas', [$this->capacity_range_first, $this->capacity_range_last]);
        }

        if ($this->sort == 'latest') {
            $productsQuery->latest();
        }

        if ($this->sort == 'kapasitas') {
            $productsQuery->orderBy('kapasitas');
        }

        return view('livewire.products-page', [
            'products' => $productsQuery->paginate(9),
        ]);
    }
}
