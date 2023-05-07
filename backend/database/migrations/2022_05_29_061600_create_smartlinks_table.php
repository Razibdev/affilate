<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartlinks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('traffic_source')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->decimal('earnings',15,10)->nullable()->default('0.0000000000');
            $table->decimal('ecpm',15,10)->nullable();
            $table->decimal('conversion_rate',15,10)->nullable();
            $table->string('traffic_quality')->nullable();
            $table->text('url')->nullable();
            $table->integer('enabled')->nullable();
            $table->integer('key_')->nullable();
            $table->integer('is_delete')->nullable();
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
        Schema::dropIfExists('smartlinks');
    }
}
