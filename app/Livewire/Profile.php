<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    public $user = [];
    public $password;
    public function mount()
    {
        $this->user =   Auth::user()->toArray();
        echo (json_encode($this->user));
    }
    public function submit_profile()
    {
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.phone' => 'nullable|regex:/^[6-9][0-9]{9}$/',
            'user.address' => 'nullable|string|max:255',
        ]);

        $currentUser = Auth::user();

        $currentUser->name = $this->user['name'];
        $currentUser->phone = $this->user['phone'];
        $currentUser->address = $this->user['address'];

        if ($this->password) {
            $currentUser->password = Hash::make($this->password);
        }

        $currentUser->save();

        session()->flash('message', 'Profile updated successfully!');
    }
    public function render()
    {
        return view('livewire.profile');
    }
}
