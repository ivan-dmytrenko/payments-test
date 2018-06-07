<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(UserWalletTableSeeder::class);
        $this->call(CurrencyUsdRateTableSeeder::class);
        $this->call(TransactionTypeTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
    }
}
