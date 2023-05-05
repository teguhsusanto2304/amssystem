<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->datetime('jurnal_at');
            $table->string('no_bukti',15);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('keterangan',100);
            $table->integer('data_status')->default(1);
            $table->unsignedBigInteger('created_by'); 
            $table->unsignedBigInteger('ammend_by')->nullable();
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('delivered_by')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->timestamp('ammend_at')->useCurrent()->nulable();
            $table->timestamp('edit_at')->useCurrent()->nulable();
            $table->timestamp('approved_at')->useCurrent()->nulable();
            $table->timestamp('delivered_at')->useCurrent()->nulable();
            $table->timestamp('received_at')->useCurrent()->nulable();
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
        Schema::dropIfExists('jurnals');
    }
}
