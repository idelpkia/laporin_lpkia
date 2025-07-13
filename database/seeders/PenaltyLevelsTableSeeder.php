<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenaltyLevel;

class PenaltyLevelsTableSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            'light' => 'Teguran lisan atau peringatan tertulis',
            'medium' => 'Skorsing sementara dari kegiatan akademik',
            'heavy' => 'Drop out atau pencabutan gelar akademik'
        ];

        foreach ($levels as $level => $desc) {
            PenaltyLevel::create([
                'level' => $level,
                'description' => $desc,
            ]);
        }
    }
}
