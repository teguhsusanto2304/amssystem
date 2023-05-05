<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('medic_code',10);
            $table->string('front_title');
            $table->string('fullname',150);
            $table->string('back_title');
            $table->date('date_of_birth');
            $table->string('gender',9);
            $table->string('address',100)->nullable();
            $table->string('phone_number',12)->nullable();
            $table->Integer('speciality_id')->nullable();
            $table->Integer('service_unit_id')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
