<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::resource('users', 'UserWalletController')
        ->only(['store']);
    Route::put('users/{default?}', 'UserWalletController@update');
    Route::resource('currencyExchangeRates', 'CurrencyRateController')
        ->only(['store']);
    Route::resource('transactions', 'TransactionController')
        ->only(['store']);
});
