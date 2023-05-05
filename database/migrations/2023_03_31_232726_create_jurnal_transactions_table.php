<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_transactions', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('jurnal_id');
            $table->unsignedBigInteger('kode_rekening_id');
            $table->decimal('debit',15,2)->default(0);
            $table->decimal('kredit',15,2)->default(0);
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
        Schema::dropIfExists('jurnal_transactions');
    }
}
