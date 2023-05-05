<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokterServiceUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokter_service_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_unit_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('service_unit_id')->references('id')->on('service_units')->onDelete('cascade'); 
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokter_service_units');
    }
}
