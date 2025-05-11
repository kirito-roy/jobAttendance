<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class Role extends Component
{
    public $users;
    public $roles = ['user', 'manager', 'admin'];
    public $deps = ['hr', 'it', 'finance', 'operations'];
    public $selectedRole = []; // Store selected roles for each user
    public $selectedDep = [];
    public function mount()
    {
        $this->users = user::all();
    }

    public function submit_role($userId)
    {
        // Validate the input
        $this->validate([
            "selectedRole.$userId" => 'required|in:' . implode(',', $this->roles),

        ]);

        // Find the user and update their role
        $user = user::find($userId);
        if ($user) {
            $user->role = $this->selectedRole[$userId];
            $user->dep = $this->selectedDep[$userId];
            $user->save();

            // Refresh the users list
            $this->users = User::all();

            // Display success message
            session()->flash('message', "Role for {$user->name} updated successfully to {$this->selectedRole[$userId]}!");
        } else {
            session()->flash('error', 'User not found.');
        }
    }
    public function delete($id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            user::where('id', $id)->delete();
            return redirect("/role");
        }
    }

    public function render()
    {
        return view('livewire.role', ['users' => $this->users]);
    }
}
