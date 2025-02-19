<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Exécution du Seeder pour insérer les données dans la base de données.
     *
     * @return void
     */
    public function run(): void
    {
        // Liste des activités industrielles
        $activities = [
            ['name' => 'صناعة الملابس'],
            ['name' => 'صناعة الأقمشة'],
            ['name' => 'صناعة الإكسسوارات النسيجية'],
            ['name' => 'صناعة الأغذية المعلبة'],
            ['name' => 'صناعة المشروبات'],
            ['name' => 'صناعة الحلويات'],
            ['name' => 'صناعة اللحوم والدواجن'],
            ['name' => 'صناعة الألبان'],
            ['name' => 'صناعة المواد الكيميائية الأساسية'],
            ['name' => 'صناعة البلاستيك'],
            ['name' => 'صناعة المنظفات'],
            ['name' => 'صناعة الأدوية والمستحضرات الصيدلانية'],
            ['name' => 'صناعة الحديد والصلب'],
            ['name' => 'صناعة الألمنيوم'],
            ['name' => 'صناعة المعادن غير الحديدية'],
            ['name' => 'صهر المعادن'],
            ['name' => 'صناعة السيارات'],
            ['name' => 'صناعة قطع الغيار'],
            ['name' => 'صناعة الدراجات النارية'],
            ['name' => 'صناعة الشاحنات والمركبات التجارية'],
            ['name' => 'صناعة مواد البناء (الخرسانة، الطوب، الإسمنت)'],
            ['name' => 'بناء المنازل والمباني السكنية'],
            ['name' => 'البناء الصناعي والتجاري'],
            ['name' => 'تشييد البنية التحتية'],
            ['name' => 'صناعة الأجهزة الإلكترونية الاستهلاكية'],
            ['name' => 'صناعة المكونات الإلكترونية'],
            ['name' => 'صناعة الأجهزة المنزلية'],
            ['name' => 'صناعة الأثاث المنزلي'],
            ['name' => 'صناعة الأثاث المكتبي'],
            ['name' => 'صناعة الأثاث المعدني والخشبي'],
            ['name' => 'صناعة المنتجات الخشبية الأخرى'],
            ['name' => 'صناعة الورق'],
            ['name' => 'صناعة الكرتون'],
            ['name' => 'صناعة منتجات الورق المخصصة'],
            ['name' => 'صناعة الأدوية والعقاقير'],
            ['name' => 'صناعة المستحضرات الصيدلانية'],
            ['name' => 'صناعة اللقاحات والمستحضرات البيولوجية'],
            ['name' => 'الطاقة المتجددة (الطاقة الشمسية، الرياح)'],
            ['name' => 'محطات توليد الكهرباء'],
            ['name' => 'صناعة النفط والغاز'],
            ['name' => 'صناعات المفاعلات النووية'],
            ['name' => 'صناعة الطباعة (الكتب، الصحف، المجلات)'],
            ['name' => 'صناعة تغليف المواد (الأغذية، الأدوية، منتجات تجارية)'],
            ['name' => 'صناعة الزجاج'],
            ['name' => 'صناعة الخزف والسيراميك'],
            ['name' => 'صناعة الأدوات الزجاجية المنزلية والصناعية'],
            ['name' => 'صناعة الأسمدة'],
            ['name' => 'صناعة المبيدات الحشرية'],
            ['name' => 'صناعة المواد الكيميائية الزراعية'],
            ['name' => 'صناعة الأحذية'],
            ['name' => 'صناعة المنتجات الجلدية (حقائب، محافظ)'],
            ['name' => 'صناعة الملابس الجلدية'],
            ['name' => 'صناعة السجائر'],
            ['name' => 'صناعة منتجات التبغ الأخرى'],
            ['name' => 'صناعة الطوب'],
            ['name' => 'صناعة الأجهزة الطبية'],
            ['name' => 'صناعة الأدوات الجراحية'],
            ['name' => 'صناعة المعدات الصحية']
        ];

        // Insertion des données dans la table 'activities'
        DB::table('activities')->insertOrIgnore($activities); // Si une activité existe déjà, elle sera ignorée
    }
}
