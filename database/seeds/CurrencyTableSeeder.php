<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('currency');

        $currenciesCodes = [
            ['code' => 'RUB'],
            ['code' => 'EUR'],
            ['code' => 'UAH'],
            ['code' => 'PLN'],
            ['code' => 'USD']
        ];

        DB::table('currency')->insert($currenciesCodes);
        $this->enableForeignKeys();
    }
}
