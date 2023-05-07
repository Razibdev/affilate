<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostbackRecieveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postback_recieve', function (Blueprint $table) {
            $table->id();
            $table->text('url')->nullable();
            $table->string('status')->nullable();
            $table->integer('offer_process_id')->nullable();
            $table->integer('offer_id')->nullable();
            $table->integer('publisher_id')->nullable();
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
        Schema::dropIfExists('postback_recieve');
    }
}
