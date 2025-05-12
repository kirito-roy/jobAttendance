<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Role extends Component
{
    public $roles = ['user', 'manager', 'admin'];
    public $deps = ['Hr', 'It', 'Finance'];
    public $selectedRole = [];
    public $selectedDep = [];
    public $search = ''; // Search term
    public $users = []; // Store filtered users

    public function mount()
    {
        $this->loadUsers(); // Load all users initially
    }

    public function searchf()
    {
        // Filter users based on the search term
        $this->loadUsers();
    }

    private function loadUsers()
    {
        $this->users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->get();

        // Initialize selectedRole and selectedDep with current values
        foreach ($this->users as $user) {
            $this->selectedRole[$user->id] = $user->role;
            $this->selectedDep[$user->id] = $user->dep;
        }
    }

    public function submit_role($userId)
    {
        // Validate the input
        $this->validate([
            "selectedRole.$userId" => 'required|in:' . implode(',', $this->roles),
            "selectedDep.$userId" => 'required|in:' . implode(',', $this->deps),
        ]);

        // Find the user and update their role and department
        $user = User::find($userId);
        if ($user) {
            $user->role = $this->selectedRole[$userId] ?? $user->role;
            $user->dep = $this->selectedDep[$userId] ?? $user->dep;
            $user->save();

            // Refresh users list
            $this->loadUsers();

            // Display success message
            session()->flash('message', "Role and department for {$user->name} updated successfully!");
        } else {
            session()->flash('error', 'User not found.');
        }
    }

    public function delete($id)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $user = User::find($id);
            if ($user) {
                $user->delete();

                // Refresh the users list
                $this->loadUsers();

                session()->flash('message', "{$user->name} has been deleted successfully.");
            } else {
                session()->flash('error', "User not found.");
            }
        } else {
            session()->flash('error', "You are not authorized to delete users.");
        }
    }

    public function render()
    {
        return view('livewire.role', ['users' => $this->users]);
    }
}
