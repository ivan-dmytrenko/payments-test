<?php

use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeTableSeeder extends Seeder
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
        $this->truncate('transaction_type');

        $transactionTypes = [
            ['code' => 'deposit'],
            ['code' => 'charge'],
            ['code' => 'chargeback'],
            ['code' => 'receiving'],
        ];

        DB::table('transaction_type')->insert($transactionTypes);
        $this->enableForeignKeys();
    }
}
