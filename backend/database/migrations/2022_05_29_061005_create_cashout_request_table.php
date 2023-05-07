<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashoutRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashout_request', function (Blueprint $table) {
            $table->id();
            $table->integer('affliate_id');
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->decimal('amount',15,10);
            $table->string('method');
            $table->text('note');
            $table->string('payterm');
            $table->string('payment_details');
            $table->string('status');
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
        Schema::dropIfExists('cashout_request');
    }
}
