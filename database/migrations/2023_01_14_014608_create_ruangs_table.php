<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang',200);
            $table->string('kode_ruang',5);
            $table->unsignedBigInteger('service_unit_id');
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('service_unit_id')->references('id')->on('service_units')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruangs');
    }
}
