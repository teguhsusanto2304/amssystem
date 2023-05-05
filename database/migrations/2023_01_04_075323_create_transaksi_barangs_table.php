<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();              
            $table->string('kunjungan_pasien_id',36); 
            $table->string('transaksi_id',36);
            $table->datetime('transaksi_at');
            $table->unsignedBigInteger('service_unit_id'); 
            $table->unsignedBigInteger('dokter_id'); 
            $table->unsignedBigInteger('barang_id');
            $table->decimal('tarif',12,2)->default(0);
            $table->integer('qty')->default(1);
            $table->unsignedBigInteger('satuan_barang_id');
            $table->decimal('discount_prosen',3,2)->default(0);
            $table->decimal('discount_nominal',12,2)->default(0);
            $table->unsignedSmallInteger('is_diskon')->default(0);
            $table->decimal('sub_total',12,2)->default(0);
            $table->string('no_antrian',10)->nullable();
            $table->string('no_transaksi',15);
            $table->unsignedSmallInteger('data_status')->default(1);
            $table->timestamps();
            $table->foreign('kunjungan_pasien_id')->references('id')->on('kunjungan_pasiens')->onDelete('cascade');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
            $table->foreign('service_unit_id')->references('id')->on('service_units')->onDelete('cascade'); 
            $table->foreign('dokter_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('satuan_barang_id')->references('id')->on('barang_satuans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_barangs');
    }
}
