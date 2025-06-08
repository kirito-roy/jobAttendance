<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\role;
use Exception;

class Manageuser extends Component
{
    public $user = [];
    public $roles = [];
    public $userrole = [];
    public $showAddModal = false;
    public $selectedRoles = [];

    public function mount($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);
            $this->user = $user->toArray();
            $this->roles = Role::pluck('role')->toArray();
            $this->loadUserRoles();
        } catch (Exception $e) {
            abort(404, 'User not found');
        }
    }

    public function loadUserRoles()
    {
        $this->userrole = User::find($this->user['id'])->roles()->pluck('role')->toArray();
    }

    public function deleteRole($roleName)
    {
        // echo "Deleting role: $roleName"; // Debugging line
        $role = Role::where('role', $roleName)->first();
        if ($role) {
            User::find($this->user['id'])->roles()->detach($role->id);
        }

        $this->loadUserRoles(); // Refresh roles
    }

    public function openModal()
    {
        $this->reset('selectedRoles');
        $this->showAddModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
    }

    public function assignRole()
    {
        $user = User::find($this->user['id']);

        foreach ($this->selectedRoles as $roleName) {
            $role = role::where('role', $roleName)->first();
            if ($role && !$user->roles->contains($role->id)) {
                $user->roles()->attach($role->id);
            }
        }

        $this->selectedRoles = [];
        $this->showAddModal = false;
        $this->loadUserRoles();

        $this->closeModal();
        session()->flash('message', 'Roles assigned successfully.');
    }

    public function render()
    {
        return view('livewire.manageuser');
    }
}
