<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            $table->string('advertiser_name');
            $table->string('company_name');
            $table->string('param1');
            $table->string('param2');
            $table->string('email');
            $table->string('password');
            $table->string('hereby');
            $table->string('status')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('advertiser_image')->nullable();
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
        Schema::dropIfExists('advertisers');
    }
}
