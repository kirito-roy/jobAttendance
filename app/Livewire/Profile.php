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
        // echo (json_encode($this->user));
    }
    public function submit_profile()
    {
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.phone' => 'nullable|regex:/^[6-9][0-9]{9}$/',
            'user.address' => 'nullable|string|max:255',
            // 'password' => 'nullable|string|min:8', // Password is optional
        ]);

        $currentUser = Auth::user();

        // Update user data
        $currentUser->name = $this->user['name'];
        $currentUser->phone = $this->user['phone'];
        $currentUser->address = $this->user['address'];

        // Update password if provided
        if ($this->password) {
            $currentUser->password = Hash::make($this->password);
        }

        $currentUser->save();

        // Flash success message
        session()->flash('message', 'Profile updated successfully!');
    }
    public function render()
    {
        return view('livewire.profile');
    }
}
