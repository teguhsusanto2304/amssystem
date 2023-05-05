<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        //$this->call(CityTableSeeder::class);
        //$this->call(DistrictTableSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(RekamMedisTableSeeder::class);
        $this->call(SpecialityTableSeeder::class);
        $this->call(JenisKunjunganTableSeeder::class);
        $this->call(JenisPerawatanTableSeeder::class);
        $this->call(KelasLayananTableSeeder::class);
        $this->call(ServiceUnitTableSeeder::class);
        $this->call(GroupLayananTableSeeder::class);
    }
}
