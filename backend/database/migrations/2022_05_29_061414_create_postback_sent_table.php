<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostbackSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postback_sent', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->string('status')->nullable();
            $table->text('url')->nullable();
            $table->decimal('payout',15,10)->nullable();
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
        Schema::dropIfExists('postback_sent');
    }
}
