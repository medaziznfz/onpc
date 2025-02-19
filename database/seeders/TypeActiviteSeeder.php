<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeActivite;

class TypeActiviteSeeder extends Seeder
{
    /**
     * Exécute les seeders de la base de données.
     */
    public function run(): void
    {
        $types = [
            'مفتوحة للعموم',
            'صناعية',
            'سكنية',
            'ذات علو شاهق'
        ];

        foreach ($types as $type) {
            TypeActivite::create(['nom' => $type]);
        }
    }
}
