<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->text('site_description');
            $table->string('logo');
            $table->string('icon');
            $table->integer('auto_signup')->nullable();
            $table->integer('minimum_withdraw_amount');
            $table->integer('payout_percentage');
            $table->string('default_affliate_manager');
            $table->string('default_payment_terms');
            $table->integer('affliate_manager_salary_percentage');
            $table->string('vpn_api');
            $table->string('vpn_check');
            $table->integer('vpn_click_limit');
            $table->string('smtp_host');
            $table->string('smtp_port');
            $table->string('smtp_user');
            $table->string('smtp_password');
            $table->string('smtp_enc');
            $table->string('from_email');
            $table->string('postback_password');
            $table->string('from_name')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
}
