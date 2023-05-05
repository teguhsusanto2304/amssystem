<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ServiceUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `service_units` (`service_unit`, `data_status`) VALUES
        ('Pendaftaran', 1),
        ('Keuangan', 1),
        ('Poli Umum', 1),
        ('Unit Gawat darurat', 1),
        ('Poli Kandungan', 1)");
    }
}
