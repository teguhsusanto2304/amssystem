<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjunganPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kunjungan_pasiens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->unsignedBigInteger('dokter_id');
            $table->unsignedBigInteger('service_unit_id');
            $table->unsignedBigInteger('penjamin_id')->nullable();
            $table->unsignedBigInteger('penanggungjawab_id')->nullable();
            $table->unsignedBigInteger('jenis_kunjungan_id');
            $table->unsignedBigInteger('jenis_perawatan_id');
            $table->datetime('kunjungan_at');
            $table->string('no_antrian',10);
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->string('no_registrasi',15);
            $table->timestamps();
            $table->foreign('rekam_medis_id')->references('id')->on('rekam_medis')->onDelete('cascade');            
            $table->foreign('dokter_id')->references('id')->on('doctors')->onDelete('cascade');            
            $table->foreign('service_unit_id')->references('id')->on('service_units')->onDelete('cascade');
            $table->foreign('jenis_kunjungan_id')->references('id')->on('jenis_kunjungans')->onDelete('cascade');
            $table->foreign('jenis_perawatan_id')->references('id')->on('jenis_perawatans')->onDelete('cascade');
            $table->foreign('penjamin_id')->references('id')->on('rekam_medis_penjamins')->onDelete('cascade');
            $table->foreign('penanggungjawab_id')->references('id')->on('rekam_medis_penanggung_jawabs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kunjungan_pasiens');
    }
}
