<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->delete();
        $states = array(
            array('id' => 3633, 'name' => "Aryanah", 'country_id' => 222),
            array('id' => 3634, 'name' => "Bajah", 'country_id' => 222),
            array('id' => 3635, 'name' => "Bin 'Arus", 'country_id' => 222),
            array('id' => 3636, 'name' => "Binzart", 'country_id' => 222),
            array('id' => 3641, 'name' => "Jundubah", 'country_id' => 222),
            array('id' => 3642, 'name' => "Madaniyin", 'country_id' => 222),
            array('id' => 3643, 'name' => "Manubah", 'country_id' => 222),
            array('id' => 3644, 'name' => "Monastir", 'country_id' => 222),
            array('id' => 3645, 'name' => "Nabul", 'country_id' => 222),
            array('id' => 3646, 'name' => "Qabis", 'country_id' => 222),
            array('id' => 3647, 'name' => "Qafsah", 'country_id' => 222),
            array('id' => 3648, 'name' => "Qibili", 'country_id' => 222),
            array('id' => 3649, 'name' => "Sfax", 'country_id' => 222),
            array('id' => 3651, 'name' => "Sidi Bu Zayd", 'country_id' => 222),
            array('id' => 3652, 'name' => "Silyanah", 'country_id' => 222),
            array('id' => 3653, 'name' => "Sousse", 'country_id' => 222),
            array('id' => 3654, 'name' => "Tatawin", 'country_id' => 222),
            array('id' => 3655, 'name' => "Tawzar", 'country_id' => 222),
            array('id' => 3656, 'name' => "Tunis", 'country_id' => 222),
            array('id' => 3657, 'name' => "Zaghwan", 'country_id' => 222),
            array('id' => 3658, 'name' => "al-Kaf", 'country_id' => 222),
            array('id' => 3659, 'name' => "al-Mahdiyah", 'country_id' => 222),
            array('id' => 3660, 'name' => "al-Munastir", 'country_id' => 222),
            array('id' => 3661, 'name' => "al-Qasrayn", 'country_id' => 222),
            array('id' => 3662, 'name' => "al-Qayrawan", 'country_id' => 222),
        );
        DB::table('states')->insert($states);
    }
}