<?php

namespace App\Repositories\Contracts;

use App\Models\{City, Country, Currency};

interface UserWalletRepositoryInterface extends RepositoryInterface
{
    public function createWithAssociation(
        array $input,
        Country $country,
        City $city,
        Currency $currency
    );

    public function getTransactions(string $userWalletName);

    public function getWithBalance(string $userWalletName);

    public function getUserWalletWithTransactionsInfo(string $userWalletName, string $dateFrom, string $dateTo);
}