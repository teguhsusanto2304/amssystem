<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisPenanggungJawabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis_penanggung_jawabs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->string('title');
            $table->string('fullname',150);
            $table->enum('tipe_penanggung_jawab',['Orangtua','Anak','Adik','Kakak','Saudara','Teman','Orang Lain']);
            $table->string('no_hp',15);
            $table->string('email',100)->nullable();
            $table->string('alamat',100);
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('rekam_medis_id')->references('id')->on('rekam_medis')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekam_medis_penanggung_jawabs');
    }
}
