<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::create([
            'name' => 'Admin User', // Replace with the desired admin name
            'email' => 'sumit.de08765431@gmail.com', // Admin email
            'password' => bcrypt('123456789'), // Admin password (hashed)
            'role' => 'admin', // Admin role
            'phone' => null, // Set to null if not provided
            'address' => null, // Set to null if not provided
            'dep' => null, // Set to null if not provided
        ]);
    }
}
