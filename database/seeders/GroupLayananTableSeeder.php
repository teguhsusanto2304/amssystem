<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class GroupLayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `group_layanans` (`group_layanan`, `data_status`, `service_unit_id`) VALUES
        ('Administrasi', 1,1),
        ('Jasa Medis', 1,2),
        ('Layanan dan Tindakan Poliklinik', 1,2),
        ('Layanan dan Tindakan Dokter', 1,2),
        ('Layanan dan Tindakan UGD', 1,2),
        ('Layanan dan Tindakan Laboratorium/Radiologi', 1,2),
        ('Layanan dan Tindakan MCU', 1,2)");
    }
}
