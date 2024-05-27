<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionArsdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('direction_arsds')->delete();
        $directions = array(
            array('id' => 1, 'name' => "إ ت ج"),
            array('id' => 2, 'name' => "إ ت م إرهاب"),
            array('id' => 3, 'name' => "إدارة التشفير"),
            array('id' => 4, 'name' => "إدارة السلامة المعلوماتية والأمن السيبرني"),
            array('id' => 5, 'name' => "إدارة الشؤون الإدارية والمالية"),
            array('id' => 6, 'name' => "إدارة العلاقات الخارجية"),
            array('id' => 7, 'name' => "إدارة المتابعة"),
            array('id' => 8, 'name' => "إدارة حماية الأفراد"),
            array('id' => 9, 'name' => "إدارة حماية الوحدات"),
            array('id' => 10, 'name' => "الإدارة العامة للإستخبارات والأمن الداخلي"),
            array('id' => 11, 'name' => "الإدارة العامة للإستخبارات والعلاقات الخارجية"),
            array('id' => 12, 'name' => "الإدارة العامة للمصالح التقنية"),
            array('id' => 13, 'name' => "المركز التقني"),
            array('id' => 14, 'name' => "المركز العسكري السينوتقني"),
            array('id' => 15, 'name' => "المركز العسكري للّغات"),
            array('id' => 16, 'name' => "المصلحة التقنية"),
            array('id' => 17, 'name' => "ضابط التنسيق"),
            array('id' => 18, 'name' => "إ إ ت"),
            array('id' => 19, 'name' => "مدرسة الإستخبارات والامن العسكري"),
            array('id' => 20, 'name' => "مركز الإستطلاع لمختلف الجيوش"),
            array('id' => 21, 'name' => "مركز دمج المعلومات"),
            array('id' => 22, 'name' => "نشرة داخلية"),
            array('id' => 23, 'name' => "وحدة الإسناد و المتابعة"),
            array('id' => 24, 'name' => "وكالة إ أ د")
        );
        DB::table('direction_arsds')->insert($directions);
    }
}
