<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{

    public $s = 10;
    public function render()
    {
        return view('livewire.home', ['s' => $this->s]);
    }
}
