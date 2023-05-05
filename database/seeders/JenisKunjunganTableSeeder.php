<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JenisKunjunganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `jenis_kunjungans` (`jenis_kunjungan`, `data_status`) VALUES
        ('Konsultasi', 1),
        ('Atas Permintaan Sendiri', 1),
        ('Gawat Darurat', 1)");
    }
}
