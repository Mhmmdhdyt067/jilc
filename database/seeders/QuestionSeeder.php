<?php

namespace Database\Seeders;

use App\Models\Tryout;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tryout = Tryout::where('title', 'Tryout Pertama TWK')->first();
        $twk = Subject::where('kode', 'TWK')->first();
        
        Question::insert([
            [
                'tryout_id' => $tryout->id,
                'subject_id' => $twk->id,
                'soal' => 'Siapa Presiden pertama Republik Indonesia?',
                'pilihan_a' => 'Soekarno',
                'pilihan_b' => 'Hatta',
                'pilihan_c' => 'Soeharto',
                'pilihan_d' => 'Megawati',
                'pilihan_e' => 'Jokowi',
                'jawaban_benar' => 'A',
            ],
        ]);
    }
}
