<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViolationType;

class ViolationTypesTableSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name' => 'Plagiarism',
                'category' => 'plagiarism',
                'description' => 'Menyalin karya orang lain tanpa atribusi',
                'code' => 'PLG-001'
            ],
            [
                'name' => 'Fabrication',
                'category' => 'fabrication',
                'description' => 'Membuat data atau hasil fiktif',
                'code' => 'FAB-002'
            ],
            [
                'name' => 'Collusion',
                'category' => 'collusion',
                'description' => 'Berkomplot untuk menipu',
                'code' => 'COL-003'
            ],
            [
                'name' => 'Document Forgery',
                'category' => 'document_forgery',
                'description' => 'Pemalsuan dokumen akademik',
                'code' => 'DOC-004'
            ],
            [
                'name' => 'Intellectual Property Violation',
                'category' => 'ip_violation',
                'description' => 'Pelanggaran Hak Kekayaan Intelektual',
                'code' => 'IPV-005'
            ],
        ];

        foreach ($types as $type) {
            ViolationType::create($type);
        }
    }
}
