<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublisherPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_payment_method', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type');
            $table->string('card_no')->nullable();
            $table->string('payment_details');
            $table->string('expiry_date')->nullable();
            $table->string('isbn_no')->nullable();
            $table->integer('publisher_id');
            $table->integer('is_primary')->nullable();
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
        Schema::dropIfExists('publisher_payment_method');
    }
}
