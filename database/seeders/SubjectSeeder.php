<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $subjects = [
                ['kode' => 'TWK', 'title' => 'Tes Wawasan Kebangsaan'],
                ['kode' => 'TIU', 'title' => 'Tes Intelegensi Umum'],
                ['kode' => 'TKP', 'title' => 'Tes Karakteristik Pribadi'],
            ];

            foreach ($subjects as $subject) {
                Subject::updateOrCreate(['kode' => $subject['kode']], $subject);
            }
        }
    }
}
