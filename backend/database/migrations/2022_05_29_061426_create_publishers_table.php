<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company_name')->nullable();
            $table->integer('affliate_manager_id')->nullable();
            $table->string('password');
            $table->string('status')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->text('address')->nullable();
            $table->string('account_type')->nullable();
            $table->string('city')->nullable();
            $table->string('skype')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('country')->nullable();
            $table->string('regions')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('website_url')->nullable();
            $table->string('monthly_traffic')->nullable();
            $table->string('category')->nullable();
            $table->decimal('balance',15,10)->nullable();
            $table->string('remember_token',100)->nullable();
            $table->string('publisher_image')->nullable();
            $table->string('phone')->nullable();
            $table->string('additional_information')->nullable();
            $table->decimal('total_earnings',15,10)->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('hereby')->nullable();
            $table->integer('expert_mode')->nullable();
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
        Schema::dropIfExists('publishers');
    }
}
