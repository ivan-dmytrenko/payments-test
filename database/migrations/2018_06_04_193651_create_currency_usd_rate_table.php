<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyUsdRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_usd_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency_code', 3);
            $table->decimal('rate', 10, 3);
            $table->date('date');
            $table->timestamps();
            $table->foreign('currency_code')
                ->references('code')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_usd_rate');
    }
}
