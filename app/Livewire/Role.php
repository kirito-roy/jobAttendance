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
    public $users = [];
    public $search = '';

    public $newUser = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => '',
        'dep' => '',
    ];

    public function mount()
    {
        $this->loadUsers(); // Load all users initially
    }

    private function loadUsers()
    {
        $this->users = User::all();
        foreach ($this->users as $user) {
            $this->selectedRole[$user->id] = $user->role;
            $this->selectedDep[$user->id] = $user->dep;
        }
    }

    public function submit_role($userId)
    {
        $this->validate([
            "selectedRole.$userId" => 'required|in:' . implode(',', $this->roles),
            "selectedDep.$userId" => 'required|in:' . implode(',', $this->deps),
        ]);

        $user = User::find($userId);
        if ($user) {
            $user->role = $this->selectedRole[$userId] ?? $user->role;
            $user->dep = $this->selectedDep[$userId] ?? $user->dep;
            $user->save();
            $this->loadUsers();
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
        $this->validate([
            'newUser.name' => 'required|string|max:255',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.password' => 'required|string|min:8',
            'newUser.role' => 'required|in:' . implode(',', $this->roles),
            'newUser.dep' => 'required|in:' . implode(',', $this->deps),
        ]);

        $user = User::create([
            'name' => $this->newUser['name'],
            'email' => $this->newUser['email'],
            'password' => Hash::make($this->newUser['password']),
            'role' => $this->newUser['role'],
            'dep' => $this->newUser['dep'],
        ]);

        $this->newUser = [
            'name' => '',
            'email' => '',
            'password' => '',
            'role' => '',
            'dep' => '',
        ];

        $this->loadUsers();

        session()->flash('message', "{$user->name} has been added successfully as a new user.");
    }

    public function render()
    {
        return view('livewire.role', ['users' => $this->users]);
    }
}
