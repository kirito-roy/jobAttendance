<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\user;
use App\Models\role;

class userSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminrole = role::create(['role' => 'admin']);
        $managerrole = role::create(['role' => 'manager']);
        $userrole = role::create(['role' => 'user']);
        // $developerrole = role::create(['role' => 'developer']);

        // Create users
        $admin = user::create([
            'name' => 'Admin user',
            'email' => 'sumit.de08765431@gmail.com',
            'password' => bcrypt('123456789'),
            'phone' => null,
            'address' => null,
            'dep' => null,
        ]);

        $manager = user::create([
            'name' => 'Manager',
            'email' => 'roy184433@gmail.com',
            'password' => bcrypt('123456789'),
            'phone' => null,
            'address' => null,
            'dep' => null,
        ]);

        $user = user::create([
            'name' => 'Sumit',
            'email' => 'sumit@gmail.com',
            'password' => bcrypt('123456789'),
            'phone' => null,
            'address' => null,
            'dep' => 'IT',
        ]);

        // Attach roles to users (many-to-many)
        $admin->roles()->attach($adminrole->id);
        $manager->roles()->attach($managerrole->id);
        $user->roles()->attach($userrole->id);
        $admin->roles()->attach($managerrole->id);
        $admin->roles()->attach($userrole->id);
    }
}
