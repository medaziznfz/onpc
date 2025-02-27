<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['name_fr' => 'Sergent', 'name_ar' => 'عريف', 'image_path' => 'grade/srg.png'],
            ['name_fr' => 'Sergent-chef', 'name_ar' => 'عريف أول', 'image_path' => 'grade/srg-chef.png'],
            ['name_fr' => 'Adjoint', 'name_ar' => 'وكيل', 'image_path' => 'grade/adj.png'],
            ['name_fr' => 'Adjoint-chef', 'name_ar' => 'وكيل أول', 'image_path' => 'grade/adj-chef.png'],
            ['name_fr' => 'Sous-lieutenant', 'name_ar' => 'ملازم', 'image_path' => 'grade/slt.png'],
            ['name_fr' => 'Lieutenant', 'name_ar' => 'ملازم أول', 'image_path' => 'grade/lt.png'],
            ['name_fr' => 'Capitaine', 'name_ar' => 'نقيب', 'image_path' => 'grade/cpt.png'],
            ['name_fr' => 'Commandant', 'name_ar' => 'رائد', 'image_path' => 'grade/cdt.png'],
            ['name_fr' => 'Lieutenant-colonel', 'name_ar' => 'مقدم', 'image_path' => 'grade/col-lt.png'],
            ['name_fr' => 'Colonel plein', 'name_ar' => 'عقيد', 'image_path' => 'grade/col-plein.png'],
            ['name_fr' => 'Colonel-major', 'name_ar' => 'عميد', 'image_path' => 'grade/col-major.png'],
            
            
        ];

        DB::table('grades')->insert($grades);
    }
}
