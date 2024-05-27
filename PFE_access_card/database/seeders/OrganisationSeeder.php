<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisations')->delete();
        $organes = array(
            array('name' => "أركان جيش البحر"),
            array('name' => "أركان جيش البر"),
            array('name' => "أركان جيش الطيران"),
            array('name' => "إدارة الأرشيف والتوثيق"),
            array('name' => "إدارة الأفراد والتكوين"),
            array('name' => "إدارة التدقيق"),
            array('name' => "إدارة التراث والإعلام والثقاقة"),
            array('name' => "إدارة التعاون والعلاقات الدولية"),
            array('name' => "إدارة التعليم العالي العسكري والبحث العلمي"),
            array('name' => "إدارة الشؤون الإدارية والمالية"),
            array('name' => "إدارة الشؤون القانونية والدراسات"),
            array('name' => "إدارة الضيعات العسكرية"),
            array('name' => "إدارة المتابعة"),
            array('name' => "إدارة المهمات العسكرية"),
            array('name' => "وكالة الإستخبارات والأمن للدفاع"),
            array('name' => "الإدارة العامة للإستخبارات والعلاقات الخارجية"),
            array('name' => "الإدارة العامة للإشارة والإعلامية"),
            array('name' => "الإدارة العامة للذخيرة والاسلحة"),
            array('name' => "الإدارة العامة للصحة العسكرية"),
            array('name' => "الإدارة العامة للباس والتموين"),
            array('name' => "الإدارة العامة للشؤون الإدارية والمالية"),
            array('name' => "الإدارة العامة للمعدات الدارجة والوقود"),
            array('name' => "الإدارة العامة للهندسة العسكرية"),
            array('name' => "الإدارة العمة للتجنيد والتعبئة"),
            array('name' => "تعاونية الجيش الوطني"),
            array('name' => "ديوان المساكن العسكرية"),
            array('name' => "مركز دمج المعلومات"),
            array('name' => "د.1"),
            array('name' => "د.2"),
            array('name' => "د.3"),
            array('name' => "د.4"),
            array('name' => "د.5"),
            array('name' => "د.6"),
            array('name' => "د.7")
        );
        DB::table('organisations')->insert($organes);
    }
}