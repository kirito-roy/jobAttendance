<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public $user;
    public function mount()
    {
        $this->user =   Auth::user();
    }
    public function submit_profile() {}
    public function render()
    {
        return view('livewire.profile');
    }
}
