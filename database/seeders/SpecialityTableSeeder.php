<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SpecialityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `specialities` (`speciality`, `data_status`) VALUES
        ('Obsgyn', 1),
        ('Umum', 1),
        ('Psikologi', 1)");
    }
}
