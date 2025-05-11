<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{

    public $s = 10;
    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login'); // ✅ Safe to redirect in mount()
        } else if (Auth::user()->role == 'admin') {
            return redirect("/admin");
        }
    }
    public function render()
    {

        return view('livewire.home', ['s' => $this->s]);
    }
}
