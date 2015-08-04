<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shops')) {
            // skip migration for existed table
            return;
        }

        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_owner');
            $table->string('shop_name');
            $table->string('shop_token');
            $table->string('shop_secret');
            $table->string('shop_url');
            $table->string('shop_domain');
            $table->string('shop_country');
            $table->string('shop_email');
            $table->string('shop_plan');
            $table->string('shop_currency');
            $table->string('province_code');
            $table->string('city');
            $table->string('address1');
            $table->string('active_theme_id');
            $table->string('active_theme_mobile_id');
            $table->dateTime('join_datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shops');
    }
}
