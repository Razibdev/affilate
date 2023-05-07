<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_process', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_id');
            $table->string('offer_name');
            $table->integer('publisher_id');
            $table->string('payout_type');
            $table->decimal('payout',15,10);
            $table->string('old_payout');
            $table->integer('advertiser_id');
            $table->string('country');
            $table->string('browser');
            $table->string('ip_address');
            $table->string('ua_target');
            $table->string('source');
            $table->string('code')->nullable();
            $table->string('sid')->nullable();
            $table->string('sid2')->nullable();
            $table->string('sid3')->nullable();
            $table->string('sid4')->nullable();
            $table->string('sid5')->nullable();
            $table->string('status')->nullable();
            $table->integer('unique_')->nullable();
            $table->integer('key_')->nullable();
            $table->decimal('admin_earned',15,10)->nullable();
            $table->decimal('affliate_manager_earnings',15,10)->nullable();
            $table->decimal('publisher_earned',15,10)->nullable();
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
        Schema::dropIfExists('offer_process');
    }
}
