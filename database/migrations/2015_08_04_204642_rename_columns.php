<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RenameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->renameColumn('shop_owner', 'owner');
            $table->renameColumn('shop_name', 'name');
            $table->renameColumn('shop_token', 'token');
            $table->renameColumn('shop_secret', 'secret');
            $table->renameColumn('shop_url', 'url');
            $table->renameColumn('shop_domain', 'domain');
            $table->renameColumn('shop_country', 'country');
            $table->renameColumn('shop_email', 'email');
            $table->renameColumn('shop_plan', 'plan');
            $table->renameColumn('shop_currency', 'currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->renameColumn('owner', 'shop_owner');
            $table->renameColumn('name', 'shop_name');
            $table->renameColumn('token', 'shop_token');
            $table->renameColumn('secret', 'shop_secret');
            $table->renameColumn('url', 'shop_url');
            $table->renameColumn('domain', 'shop_domain');
            $table->renameColumn('country', 'shop_country');
            $table->renameColumn('email', 'shop_email');
            $table->renameColumn('plan', 'shop_plan');
            $table->renameColumn('currency', 'shop_currency');
        });
    }
}
