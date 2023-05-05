<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JenisPerawatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `jenis_perawatans` (`jenis_perawatan`, `data_status`) VALUES
        ('Rawat Jalan', 1),
        ('Laboratorium/Radiologi', 1),
        ('Medical Check Up', 1)");
    }
}
