<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    public function run()
    {
        $formations = [
            'تكوين لفائدة سائقي سيارات الأجرة',
            'تكوين لفائدة فرق التدخل الأولي بالمنشأت العمومية و المؤسسات التابعة للخواص',
            'تكوين في ميدان الأسعافات الأولية',
            'تكوين لفائدة السباحين المنقذين',
            'تكوين لفائدة أعوان مؤسسات السلامة و الحراسات',
            'تكوين في ميدان الوقاية',
            'تكوين في ميدان حرائق السفن',
            'تكوين لفائدة مدربي الإسعافات الأولية',
            'تكوين في ميدان حرائق السوائل و المحروقات'
        ];

        foreach ($formations as $formation) {
            DB::table('formation')->insert([
                'name'       => $formation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
