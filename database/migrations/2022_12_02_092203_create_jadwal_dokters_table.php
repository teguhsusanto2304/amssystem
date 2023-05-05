<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalDoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->enum('hari',['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
            $table->integer('index_hari');
            $table->string('jam_mulai',5);
            $table->string('jam_akhir',5);
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
        Schema::dropIfExists('jadwal_dokters');
    }
}
