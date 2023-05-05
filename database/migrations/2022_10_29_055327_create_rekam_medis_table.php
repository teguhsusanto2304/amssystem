<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_no',10);
            $table->string('title');
            $table->string('fullname',150);
            $table->date('date_of_birth');
            $table->string('gender',9);
            $table->string('address',100)->nullable();
            $table->Integer('province_id')->nullable();
            $table->Integer('city_id')->nullable();
            $table->Integer('education_id')->nullable();
            $table->Integer('work_id')->nullable();
            $table->string('postal_code',5)->nullable();
            $table->Integer('marital_status')->default(1);
            $table->string('phone_number',12)->nullable();
            $table->string('blood_type',3)->nullable();
            $table->integer('identity_type')->nullable();
            $table->string('identity_number',20)->nullable();
            $table->integer('data_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekam_medis');
    }
}
