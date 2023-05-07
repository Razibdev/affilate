<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('offer_name')->nullable();
            $table->string('offer_type')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('link')->nullable();
            $table->text('preview_url')->nullable();
            $table->text('preview_link')->nullable();
            $table->text('icon_url')->nullable();
            $table->string('lead_qty')->nullable();
            $table->string('verticals')->nullable();
            $table->decimal('payout',15,10)->nullable();
            $table->string('payout_type')->nullable();
            $table->text('countries')->nullable();
            $table->text('ua_target')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('conversion')->nullable();
            $table->tinyInteger('featured_offer')->nullable();
            $table->tinyInteger('incentive_allowed')->nullable();
            $table->tinyInteger('smartlink');
            $table->tinyInteger('magiclink')->nullable();
            $table->tinyInteger('native')->nullable();
            $table->tinyInteger('lockers')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->string('status')->nullable();
            $table->string('browsers')->nullable();
            $table->integer('leads')->nullable();
            $table->decimal('payout_percentage',15,10)->nullable();
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
        Schema::dropIfExists('offers');
    }
}
