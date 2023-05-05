<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('kode_rekening_type')->nullable();
            $table->string('kode_rekening',15);
            $table->unsignedSmallInteger('is_parent')->default(0);
            $table->integer('parent')->nullable();
            $table->string('nama_rekening',100);
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
        Schema::dropIfExists('coas');
    }
}
