<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan_tarifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layanan_id');    
            $table->unsignedBigInteger('kelas_id');  
            $table->decimal('tarif',12,2)->default(0); 
            $table->decimal('diskon',5,2)->default(0);      
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();   
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade'); 
            $table->foreign('kelas_id')->references('id')->on('kelas_layanans')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan_tarifs');
    }
}
