<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    public $roles = [];
    public $users = [];
    public $search = '';
    public $selectedRole = [];
    public $selectedDep = [];
    public $deps = ['Hr', 'It', 'Finance'];

    public $newUser = [
        'name' => '',
        'email' => '',
        'password' => '',

    ];

    public function mount()
    {
        $this->loadRoles();
        $this->loadUsers();
    }


    public function loadRoles()
    {
        $this->roles = Role::pluck('role')->toArray();
    }

    private function loadUsers()
    {
        $this->users = User::with('roles')->get();

        foreach ($this->users as $user) {
            $this->selectedDep[$user->id] = $user->dep;

            // Collect the 'role' field from each related Role model
            $this->selectedRole[$user->id] = $user->roles->pluck('role')->toArray();
        }
        echo (json_encode($this->selectedRole[1]));
    }


    // public function submit_role($userId)
    // {
    //     $this->validate([
    //         "selectedRole.$userId" => 'required|array',
    //         "selectedRole.$userId.*" => 'in:' . implode(',', $this->roles),
    //         "selectedDep.$userId" => 'required|in:' . implode(',', $this->deps),
    //     ]);

    //     $user = User::find($userId);
    //     if ($user) {
    //         // Update department
    //         $user->dep = $this->selectedDep[$userId];
    //         $user->save();

    //         // Sync roles
    //         $roleIds = Role::whereIn('role', $this->selectedRole[$userId])->pluck('id')->toArray();
    //         $user->roles()->sync($roleIds);

    //         $this->loadUsers();
    //         session()->flash('message', "Role(s) and department for {$user->name} updated successfully!");
    //     } else {
    //         session()->flash('error', 'User not found.');
    //     }
    // }

    public function delete($id)
    {
        $currentUser = Auth::user();

        if ($currentUser && $currentUser->roles->pluck('role')->contains('admin')) {
            $user = User::find($id);
            if ($user) {
                $user->roles()->detach();
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
        ]);

        $user = User::create([
            'name' => $this->newUser['name'],
            'email' => $this->newUser['email'],
            'password' => Hash::make($this->newUser['password']),
        ]);

        // Attach role

        // Reset form
        $this->newUser = [
            'name' => '',
            'email' => '',
            'password' => '',

        ];

        $this->loadUsers();
        session()->flash('message', "{$user->name} has been added successfully as a new user.");
    }

    public function render()
    {
        return view('livewire.users');
    }
}
