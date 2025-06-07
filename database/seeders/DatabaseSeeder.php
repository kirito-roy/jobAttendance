<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\userhasrole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $userSeeder = new UserSeeder();
        $userSeeder->run();
        // $rolehasseed = new UserhasroleSeeder();
        // $rolehasseed->run();
    }
}
