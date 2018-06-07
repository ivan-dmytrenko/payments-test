<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->string('currency_code', 3);
            $table->string('country_name');
            $table->string('city_name');
            $table->timestamps();
            $table->foreign('currency_code')
                ->references('code')->on('currency');
            $table->foreign('country_name')
                ->references('name')->on('country');
            $table->foreign('city_name')
                ->references('name')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet');
    }
}
