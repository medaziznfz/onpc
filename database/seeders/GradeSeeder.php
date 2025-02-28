<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['name_fr' => 'Sergent', 'name_ar' => 'عريف', 'image_path' => 'grades/srg.png'],
            ['name_fr' => 'Sergent-chef', 'name_ar' => 'عريف أول', 'image_path' => 'grades/srg-chef.png'],
            ['name_fr' => 'Adjoint', 'name_ar' => 'وكيل', 'image_path' => 'grades/adj.png'],
            ['name_fr' => 'Adjoint-chef', 'name_ar' => 'وكيل أول', 'image_path' => 'grades/adj-chef.png'],
            ['name_fr' => 'Sous-lieutenant', 'name_ar' => 'ملازم', 'image_path' => 'grades/slt.png'],
            ['name_fr' => 'Lieutenant', 'name_ar' => 'ملازم أول', 'image_path' => 'grades/lt.png'],
            ['name_fr' => 'Capitaine', 'name_ar' => 'نقيب', 'image_path' => 'grades/cpt.png'],
            ['name_fr' => 'Commandant', 'name_ar' => 'رائد', 'image_path' => 'grades/cdt.png'],
            ['name_fr' => 'Lieutenant-colonel', 'name_ar' => 'مقدم', 'image_path' => 'grades/col-lt.png'],
            ['name_fr' => 'Colonel plein', 'name_ar' => 'عقيد', 'image_path' => 'grades/col-plein.png'],
            ['name_fr' => 'Colonel-major', 'name_ar' => 'عميد', 'image_path' => 'grades/col-major.png'],
            
            
        ];

        DB::table('grades')->insert($grades);
    }
}
