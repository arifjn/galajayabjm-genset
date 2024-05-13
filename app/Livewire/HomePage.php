<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('PT. Gala Jaya Banjarmasin - Generator Set Specialized')]

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page');
    }
}
