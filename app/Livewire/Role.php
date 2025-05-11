<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Role extends Component
{
    public $users;
    public $roles = ['user', 'manager', 'admin'];
    public $selectedRole = []; // Store selected roles for each user

    public function mount()
    {
        $this->users = User::all();
    }

    public function submit_role($userId)
    {
        // Validate the input
        $this->validate([
            "selectedRole.$userId" => 'required|in:' . implode(',', $this->roles),
        ]);

        // Find the user and update their role
        $user = User::find($userId);
        if ($user) {
            $user->role = $this->selectedRole[$userId];
            $user->save();

            // Refresh the users list
            $this->users = User::all();

            // Display success message
            session()->flash('message', "Role for {$user->name} updated successfully to {$this->selectedRole[$userId]}!");
        } else {
            session()->flash('error', 'User not found.');
        }
    }

    public function render()
    {
        return view('livewire.role', ['users' => $this->users]);
    }
}
