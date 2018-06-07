<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_code');
            $table->string('owner');
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_usd', 10, 2);
            $table->timestamps();
            $table->foreign('type_code')
                ->references('code')->on('transaction_type');
            $table->foreign('owner')
                ->references('name')->on('user_wallet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
