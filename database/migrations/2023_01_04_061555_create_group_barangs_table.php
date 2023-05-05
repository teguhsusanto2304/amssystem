<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('group_barang',100);
            
            $table->unsignedBigInteger('kode_rekening_id');              
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('kode_rekening_id')->references('id')->on('kode_rekenings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_barangs');
    }
}
