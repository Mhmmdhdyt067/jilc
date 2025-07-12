<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'admin',
            'username' => 'administrator',
            'role' => 'admin',
            'password' => bcrypt('12345'),
        ]);

        $this->call(SubjectSeeder::class);
    }
}
