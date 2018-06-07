<?php
namespace App\Repositories;

use App\Models\TransactionType;
use App\Repositories\Contracts\TransactionTypeRepositoryInterface;

class TransactionTypeRepository extends Repository implements TransactionTypeRepositoryInterface
{
    public function __construct(TransactionType $transactionTypeModel)
    {
        $this->model = $transactionTypeModel;
    }

    public function getDepositType()
    {
        return $this->findOrFail('deposit');
    }

    public function getChargeType()
    {
        return $this->findOrFail('charge');
    }

    public function getChargeBackType()
    {
        return $this->findOrFail('chargeback');
    }

    public function getReceivingType()
    {
        return $this->findOrFail('receiving');
    }
}