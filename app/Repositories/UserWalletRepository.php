<?php

namespace App\Repositories;

use App\Models\{City, Country, Currency, UserWallet};
use App\Repositories\Contracts\UserWalletRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserWalletRepository extends Repository implements UserWalletRepositoryInterface
{
    public function __construct(UserWallet $userWalletModel)
    {
        $this->model = $userWalletModel;
    }

    public function createWithAssociation(
        array $input,
        Country $country,
        City $city,
        Currency $currency
    )
    {
        $this->fill($input);
        $this->model->country()->associate($country);
        $this->model->city()->associate($city);
        $this->model->currencyCode()->associate($currency);
        $this->model->save();
    }

    public function getTransactions(string $userWalletName)
    {
        $userWallet = $this->findOrFail($userWalletName);
        return $userWallet->transactions;
    }

    public function getWithBalance(string $userWalletName)
    {
        $userWallet = $this->findOrFail($userWalletName);
        $userWallet->balance = $userWallet->transactions->sum('amount');
        return $userWallet;
    }

    public function getUserWalletWithTransactionsInfo(string $userWalletName, string $fromDate = null, string $toDate = null)
    {
        $userWallet = $this->findOrFail($userWalletName);

        $transactionRaw = DB::table('user_wallet')
            ->select(DB::raw('user_wallet.name,
                user_wallet.currency_code,
                sum(transaction.amount) OVER (PARTITION by user_wallet.name) AS amount_total,
                sum(transaction.amount_usd) OVER (PARTITION by user_wallet.name) AS amount_usd_total,
                transaction.type_code,
                transaction.amount,
                transaction.created_at'
            ))
            ->leftJoin('transaction', 'user_wallet.name', '=', 'transaction.owner')
            ->where('user_wallet.name', $userWalletName);
        if (is_null($fromDate) !== true) {
            $transactionRaw->whereRaw("transaction.created_at >= date('{$fromDate}')");
        }
        if (is_null($toDate) !== true) {
            $dateTime = new \DateTime($toDate);
            $dateTime->modify('+1 day');
            $toDateFormatted = $dateTime->format('Y-m-d');
            $transactionRaw->whereRaw("transaction.created_at < date('{$toDateFormatted}')");
        }

        $transactionRawCollection = $transactionRaw->get();
        if ($transactionRawCollection->isEmpty() !== true) {
            $userWallet->totalTransactionsAmount = $transactionRawCollection->first()->amount_total;
            $userWallet->totalUsdTransactionsAmount = $transactionRawCollection->first()->amount_usd_total;
        }
        $userWallet->transactionsRaw = $transactionRawCollection;

        return $userWallet;
    }
}