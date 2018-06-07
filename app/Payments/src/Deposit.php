<?php
namespace App\Payments;

use App\Payments\Contracts\DepositInterface;

class Deposit extends Payment implements DepositInterface
{
    public function prepare(string $userWalletName, string $amount)
    {
        $this->initWallet($userWalletName);
        $this->initPaymentCurrency($this->getWalletCurrency());
        $this->initAmounts($amount);
    }

    public function processDeposit()
    {
        $this->transactionRepo->place(
            $this->transactionTypeRepo->getDepositType(),
            $this->getAmount(),
            $this->getAmountOrigin(),
            $this->getWallet()
        );
    }
}