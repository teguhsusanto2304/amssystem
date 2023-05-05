<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_units', function (Blueprint $table) {
            $table->id();
            $table->string('service_unit',100);
            $table->enum('tipe_service_unit',['Medis','Umum'])->default('Medis');
            $table->Integer('speciality_id')->nullable();
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
        Schema::dropIfExists('service_units');
    }
}
