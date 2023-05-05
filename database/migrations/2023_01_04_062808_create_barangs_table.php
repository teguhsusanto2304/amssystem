<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang',10);
            $table->string('nama_barang',100);
            $table->string('deskripsi',150)->nullable();
            $table->unsignedBigInteger('group_barang_id');
            $table->unsignedBigInteger('satuan_barang_id');
            $table->unsignedSmallInteger('data_status')->default(1); 
            $table->decimal('harga_dasar',12,2)->default(0);
            $table->timestamps();
            $table->foreign('group_barang_id')->references('id')->on('group_barangs')->onDelete('cascade');
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
        Schema::dropIfExists('barangs');
    }
}
