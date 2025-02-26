<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    public function run()
    {
        $formations = [
            [
                'id' => 1,
                'name' => 'تكوين لفائدة ساقتي سيارات الآجرة ووسائل النقل العمومي',
                'prix' => 100,
                'periode' => 1
            ],
            [
                'id' => 2,
                'name' => 'تكوين لفائدة أعضاء فرق السلامة بالمؤسسات',
                'prix' => 300,
                'periode' => 1
            ],
            [
                'id' => 3,
                'name' => 'تكوين في ميدان الإسعافات الأولية', 
                'prix' => 240,
                'periode' => 1
            ],
            [
                'id' => 4,
                'name' => 'تكوين لفائدة السباحين المتفذين',
                'prix' => 400,
                'periode' => 1
            ],
            [
                'id' => 5,
                'name' => 'التكوين في اختصاص الوقاية درجة أولى',
                'prix' => 600,
                'periode' => 2
            ],
            [
                'id' => 6,
                'name' => 'التكوين في اختصاص الوقاية درجة ثانية',
                'prix' => 600,
                'periode' => 3
            ],
            [
                'id' => 7,
                'name' => 'التكوين في اختصاص حرائق السفن',
                'prix' => 800,
                'periode' => 1
            ],
            [
                'id' => 8,
                'name' => 'تكوين لفائدة مدربي الإسعافات الأولية',
                'prix' => 600,
                'periode' => 1 
            ],
            [
                'id' => 9,
                'name' => 'تكوين في ميدان حرائق السوائل و المحروقات',
                'prix' => 1200,
                'periode' => 1 
            ]
        ];

        foreach ($formations as $formation) {
            DB::table('formation')->insert($formation);
        }
    }
}