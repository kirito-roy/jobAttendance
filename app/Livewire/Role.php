<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Role extends Component
{
    public $roles = ['user', 'manager', 'admin'];
    public $deps = ['Hr', 'It', 'Finance'];
    public $selectedRole = [];
    public $selectedDep = [];
    public $users = []; // Store filtered users
    public $newUser = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => 'user',
        'dep' => 'Hr',
    ]; // New user details

    public function mount()
    {
        $this->loadUsers(); // Load all users initially
    }

    private function loadUsers()
    {
        $this->users = User::all();

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

    public function createUser()
    {
        // Validate new user input
        $this->validate([
            'newUser.name' => 'required|string|max:255',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.password' => 'required|string|min:8',
            'newUser.role' => 'required|in:' . implode(',', $this->roles),
            'newUser.dep' => 'required|in:' . implode(',', $this->deps),
        ]);

        // Create the new user
        $user = User::create([
            'name' => $this->newUser['name'],
            'email' => $this->newUser['email'],
            'password' => Hash::make($this->newUser['password']),
            'role' => $this->newUser['role'],
            'dep' => $this->newUser['dep'],
        ]);

        // Clear the new user form
        $this->newUser = [
            'name' => '',
            'email' => '',
            'password' => '',
            'role' => 'user',
            'dep' => 'Hr',
        ];

        // Refresh the users list
        $this->loadUsers();

        // Display success message
        session()->flash('message', "{$user->name} has been added successfully as a new user.");
    }

    public function render()
    {
        return view('livewire.role', ['users' => $this->users]);
    }
}
