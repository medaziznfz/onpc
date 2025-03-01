<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    { 
        $this->call([
            GradeSeeder::class,
            UsersSeeder::class,
            GouverSeeder::class,
            DelegSeeder::class,
            TypeActiviteSeeder::class,
            ActivitySeeder::class,
            ActivityErpSeeder::class,
            DocumentSeeder::class,
            FormationSeeder::class,
        ]);
    }
}
