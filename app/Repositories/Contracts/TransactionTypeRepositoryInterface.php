<?php
namespace App\Repositories\Contracts;

interface TransactionTypeRepositoryInterface extends RepositoryInterface
{
    public function getDepositType();

    public function getChargeType();

    public function getChargeBackType();

    public function getReceivingType();
}