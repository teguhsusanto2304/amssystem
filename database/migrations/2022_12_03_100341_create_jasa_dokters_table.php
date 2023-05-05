<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaDoktersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa_dokters', function (Blueprint $table) {
            $table->id();
            $table->integer('nama_jasa_dokter');
            $table->decimal('prosentase_jasa_dokter');
            $table->decimal('prosentase_rumah_sakit');
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
        Schema::dropIfExists('jasa_dokters');
    }
}
