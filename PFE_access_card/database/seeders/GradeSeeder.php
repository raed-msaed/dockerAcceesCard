<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('grades')->delete();
        $grades = array(
            array('name' => "فريق أول", 'category_id' => 1),
            array('name' => "فريق", 'category_id' => 1),
            array('name' => "أمير لواء", 'category_id' => 1),
            array('name' => "عميد", 'category_id' => 1),
            array('name' => "عقيد", 'category_id' => 1),
            array('name' => "مقدم", 'category_id' => 1),
            array('name' => "رائد", 'category_id' => 1),
            array('name' => "نقيب", 'category_id' => 1),
            array('name' => "ملازم أول", 'category_id' => 1),
            array('name' => "ملازم", 'category_id' => 1),
            array('name' => "وكيل أعلى", 'category_id' => 2),
            array('name' => "وكيل أول", 'category_id' => 2),
            array('name' => "وكيل", 'category_id' => 2),
            array('name' => "عريف أول", 'category_id' => 2),
            array('name' => "عريف", 'category_id' => 2),
            array('name' => "رقيب أول", 'category_id' => 3),
            array('name' => "رقيب", 'category_id' => 3),
            array('name' => "جندي أول", 'category_id' => 3),
            array('name' => "جندي متطوع", 'category_id' => 3),
        );
        DB::table('grades')->insert($grades);
    }
}
