<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('report', 'TransactionReportController@index')->name('report.index');
Route::post('report/export_csv', 'TransactionReportController@exportCsvReport')->name('report.export_csv');
