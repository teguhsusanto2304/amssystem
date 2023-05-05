<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_layanan',10);
            $table->string('nama_layanan',100);
            $table->unsignedBigInteger('group_layanan_id');  
            $table->unsignedBigInteger('kode_rekening_id');   
            $table->unsignedBigInteger('jasa_dokter_id');            
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();        
            $table->foreign('group_layanan_id')->references('id')->on('group_layanans')->onDelete('cascade'); 
            $table->foreign('kode_rekening_id')->references('id')->on('kode_rekenings')->onDelete('cascade'); 
            $table->foreign('jasa_dokter_id')->references('id')->on('jasa_dokters')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanans');
    }
}
