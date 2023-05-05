<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananServiceUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan_service_units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_unit_id');
            $table->unsignedBigInteger('layanan_id');
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('service_unit_id')->references('id')->on('service_units')->onDelete('cascade'); 
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan_service_units');
    }
}
