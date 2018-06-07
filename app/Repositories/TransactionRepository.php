<?php

namespace App\Repositories;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\UserWallet;

class TransactionRepository extends Repository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $transactionModel)
    {
        $this->model = $transactionModel;
    }

    public function place(
        TransactionType $transactionType,
        string $amount,
        string $amountInOrigin,
        UserWallet $userWallet
    ) {
        $this->create([
            'amount' => $amount,
            'amount_usd' => $amountInOrigin,
            'type_code' => $transactionType->code,
            'owner' => $userWallet->name
        ]);
//        $this->model->typeCode()->associate($transactionType);
//        $this->model->ownerName()->associate($userWallet);
//        $this->model->save();
    }
}