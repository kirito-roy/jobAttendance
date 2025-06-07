<?php

namespace Database\Seeders;

use App\Models\userhasrole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserhasroleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        userhasrole::create([
            'user_id' => 1,
            'role_id' => 3
        ]);
        userhasrole::create([
            'user_id' => 1,
            'role_id' => 1
        ]);
        userhasrole::create([
            'user_id' => 1,
            'role_id' => 2
        ]);

        //
    }
}
