<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rekam_medis_id');
            $table->string('title');
            $table->string('fullname',150);
            $table->date('date_of_birth');
            $table->string('gender',9);
            $table->string('phone_number',20);
            $table->unsignedBigInteger('dokter_id');
            $table->unsignedBigInteger('service_unit_id');
            $table->datetime('appointment_at');
            $table->string('no_antrian',10);
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->unsignedBigInteger('kunjungan_pasien_id');
            $table->string('keterangan',150)->nullable();
            $table->timestamps();            
            $table->foreign('dokter_id')->references('id')->on('doctors')->onDelete('cascade');            
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
        Schema::dropIfExists('appointments');
    }
}
