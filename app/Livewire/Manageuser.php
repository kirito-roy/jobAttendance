<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\user;
use App\Models\role;
use App\Models\userhasrole;
use Exception;

class Manageuser extends Component
{
    public $user = [];
    public $roles = [];
    public $deps = [];
    public $userrole = [];
    public $showAddModal = false;
    public $selectedRoles = [];


    public function mount($id)
    {
        try {
            $this->user = user::findOrFail($id)->toArray();
            $this->roles = role::pluck('role')->toArray();
            $this->loadUserRoles();
        } catch (Exception $e) {
            abort(404, 'User not found');
        }
    }

    public function loadUserRoles()
    {
        $this->userrole = [];

        $roleIds = userhasrole::where('user_id', $this->user['id'])->pluck('role_id');

        $this->userrole = role::whereIn('id', $roleIds)->pluck('role')->toArray();
    }

    public function deleteRole($role)
    {
        $roleId = Role::where('role', $role)->value('id');

        if ($roleId) {
            userhasrole::where('user_id', $this->user['id'])
                ->where('role_id', $roleId)
                ->delete();
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
        foreach ($this->selectedRoles as $roleName) {
            $role = role::where('role', $roleName)->first();

            if ($role) {
                $exists = userhasrole::where('user_id', $this->user['id'])
                    ->where('role_id', $role->id)
                    ->exists();

                if (!$exists) {
                    userhasrole::create([
                        'user_id' => $this->user['id'],
                        'role_id' => $role->id,
                    ]);
                }
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
