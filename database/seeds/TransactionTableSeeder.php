<?php

use Carbon\Carbon;
use Database\traits\TruncateTable;
use Database\traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTableSeeder extends Seeder
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
        $this->truncate('transaction');

        $userWallets = DB::table('user_wallet')->pluck('name')->toArray();
        $transactionTypes = DB::table('transaction_type')->pluck('code')->toArray();
        $transactions = [];
        foreach ($userWallets as $userWallet) {
            foreach ($transactionTypes as $transactionType) {
                $randAmount = random_int(1, 300);
                $signAmount = $transactionType === 'charge' ? -$randAmount : $randAmount;
                $transactions[] =
                    [
                        'type_code' => $transactionType,
                        'owner' => $userWallet,
                        'amount' => $signAmount,
                        'amount_usd' => bcdiv($signAmount, '1.176'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];
            }
        }

        DB::table('transaction')->insert($transactions);

        $this->enableForeignKeys();
    }
}
