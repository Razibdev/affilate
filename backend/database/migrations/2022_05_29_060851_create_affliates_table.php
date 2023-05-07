<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affliates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('status')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->string('remember_token',100)->nullable();
            $table->text('address')->nullable();
            $table->string('skype')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('balance',15,10)->nullable();
            $table->decimal('total_earnings',15,10)->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_description')->nullable();
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
        Schema::dropIfExists('affliates');
    }
}
