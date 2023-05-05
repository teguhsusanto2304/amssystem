<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = $faker->addProvider(new \Bezhanov\Faker\Provider\Medicine($faker));
 
    	for($i = 1; $i <= 50; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('rekam_medis')->insert([
                'medical_record_no'=>str_pad($i,8,"0",STR_PAD_LEFT),
                'title'=>$faker->title,
    			'fullname' => $faker->name,
    			'date_of_birth' =>$faker->dateTimeBetween('1990-01-01', '2012-12-31')
                ->format('Y-m-d'),
    			'gender' => $faker->randomElement(['Lelaki', 'Perempuan']),
    			'address' => $faker->address,
                'province_id'=>1,
                'city_id'=>2,
                'postal_code'=>'55514',
                'phone_number'=>substr($faker->phoneNumber,0,12),
                'blood_type'=>'O',
                'identity_type'=>1,
                'identity_number'=>'2345677888',
                'data_status'=>1

    		]);
 
    	}
    }
}
