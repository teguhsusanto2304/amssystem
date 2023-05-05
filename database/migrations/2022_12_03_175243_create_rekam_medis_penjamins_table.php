<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisPenjaminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis_penjamins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->string('pemegang',150);
            $table->string('penjamin',100);
            $table->enum('tipe_penjamin',['Asuransi','Perushaaan']);
            $table->string('nomor_penjamin',20);
            $table->date('tgl_berakhir')->nullable();
            $table->unsignedSmallInteger('data_status')->default(1);
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
        Schema::dropIfExists('rekam_medis_penjamins');
    }
}
