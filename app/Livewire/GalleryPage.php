<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryPage extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.gallery-page', [
            'galleries' => Gallery::latest()->paginate(8),
        ]);
    }
}
