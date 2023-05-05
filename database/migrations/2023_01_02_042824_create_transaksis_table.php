<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary();              
            $table->string('kunjungan_pasien_id',36); 
            $table->datetime('transaksi_at');
            $table->unsignedBigInteger('service_unit_id'); 
            $table->timestamps();
            $table->string('no_antrian',10);
            $table->string('no_transaksi',15);
            $table->decimal('total',12,2)->default(0);
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->foreign('kunjungan_pasien_id')->references('id')->on('kunjungan_pasiens')->onDelete('cascade');
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
        Schema::dropIfExists('transaksis');
    }
}
