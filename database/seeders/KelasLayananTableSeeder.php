<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class KelasLayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `kelas_layanans` (`kelas_layanan`, `data_status`) VALUES
        ('Rawat Jalan', 1),
        ('Medical Check Up', 1),
        ('Gawat Darurat', 1)");
    }
}
