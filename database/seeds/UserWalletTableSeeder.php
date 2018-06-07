<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserWalletTableSeeder extends Seeder
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
        $this->truncate('user_wallet');

        $country = DB::table('country')->pluck('name')->first();
        $city = DB::table('city')->pluck('name')->first();
        $userWallets = [
            [
                'name' => 'Test',
                'currency_code' => 'EUR',
                'country_name' => $country,
                'city_name' => $city
            ]
        ];

        DB::table('user_wallet')->insert($userWallets);

        $this->enableForeignKeys();
    }
}
