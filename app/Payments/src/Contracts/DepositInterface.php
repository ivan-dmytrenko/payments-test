<?php
namespace App\Payments\Contracts;

interface DepositInterface
{
    public function prepare(string $userWalletName, string $amount);

    public function processDeposit();
}