<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffliateWithdrawTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affliate_withdraw', function (Blueprint $table) {
            $table->id();
            $table->integer('affliate_id');
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->decimal('amount',15,10);
            $table->string('method')->nullable();
            $table->text('note');
            $table->string('payterm');
            $table->string('payment_details')->nullable();
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
        Schema::dropIfExists('affliate_withdraw');
    }
}
