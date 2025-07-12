<?php

namespace Database\Seeders;

use App\Models\Tryout;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TryoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $twk = Subject::where('kode', 'TWK')->first();

        Tryout::create([
            'title' => 'Tryout Pertama TWK',
            'waktu' => 30,
        ]);
    }
}
