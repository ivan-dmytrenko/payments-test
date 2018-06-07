<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyUsdRateTableSeeder extends Seeder
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
        $this->truncate('currency_usd_rate');

        $currencyCodes = DB::table('currency')->pluck('code')->toArray();
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d');
        $currencyUSDRates =   [
            'RUB' => '0.016',
            'EUR' => '1.176',
            'UAH' => '0.038',
            'PLN' => '0.275'
        ];
        $currencyToUsdRates = [];
        foreach ($currencyCodes as $currencyCode) {
            if ($currencyCode === 'USD') {
                continue;
            }
            $currencyToUsdRates[] =
                [
                    'currency_code' => $currencyCode,
                    'rate' => $currencyUSDRates[$currencyCode],
                    'date' => $date,
                    'created_at' => $dateTime->format('Y-m-d H:i:s')
                ];
        }

        DB::table('currency_usd_rate')->insert($currencyToUsdRates);

        $this->enableForeignKeys();
    }
}
