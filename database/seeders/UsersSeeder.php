<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default user
        User::create([
            'name' => 'onpc',
            'email' => 'onpc@onpc.com',
            'cin' => '00000000',  // This is stored as integer
            'role' => 2,          // Default role (2 in this case)
            'gouver' => null,     // No value for 'gouver', it can be left null if allowed in the schema
            'password' => Hash::make('123456789'),  // Password hashed using Laravel's Hash facade
        ]);
    }
}
