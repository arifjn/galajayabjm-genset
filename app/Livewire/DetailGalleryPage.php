<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;

class DetailGalleryPage extends Component
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.detail-gallery-page', [
            'gallery' => Gallery::where('slug', $this->slug)->firstOrFail(),
            'galleries' => Gallery::orderByRaw('RAND()')->take(5)->paginate(5),
        ]);
    }
}
