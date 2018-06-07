<?php

namespace App\Repositories\Contracts;

use App\Models\{TransactionType, UserWallet};

interface TransactionRepositoryInterface extends RepositoryInterface
{
    public function place(
        TransactionType $transactionType,
        string $amount,
        string $amountInOrigin,
        UserWallet $userWallet
    );
}