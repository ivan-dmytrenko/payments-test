<?php
namespace App\Payment;

use App\Payments\Contracts\ChargeInterface;
use App\Payments\Payment;
use App\Payments\Exceptions\NotEnoughMoneyException;

class Charge extends Payment implements ChargeInterface
{
    protected $senderWallet;

    protected $receiverWallet;

    protected $amountInSenderWalletCurrency;

    protected $amountInReceiverWalletCurrency;

    protected function initSenderWallet(string $senderName)
    {
        $this->senderWallet = $this->userWalletRepo->getWithBalance($senderName);
    }

    protected function initReceiverWallet(string $receiverName)
    {
        $this->receiverWallet = $this->userWalletRepo->findOrFail($receiverName);
    }

    public function preparePayment(string $currencyTo, string $senderName, string $amount, string $receiverName)
    {
        $this->initSenderWallet($senderName);
        $this->initReceiverWallet($receiverName);
        $this->initPaymentCurrency($currencyTo);
        $this->initAmounts($amount);
        $this->checkIsEnoughBalance($currencyTo, $senderName, $amount);
        $this->initAmountInSenderWalletCurrency();
        $this->initAmountInReceiverWalletCurrency();
    }

    public function processChargePayment()
    {
        $this->transactionRepo->place(
            $this->transactionTypeRepo->getChargeType(),
            -$this->amountInSenderWalletCurrency,
            -$this->getAmountOrigin(),
            $this->senderWallet
        );
    }

    public function processReceivePayment()
    {
        $this->transactionRepo->place(
            $this->transactionTypeRepo->getReceivingType(),
            $this->amountInReceiverWalletCurrency,
            $this->getAmountOrigin(),
            $this->receiverWallet
        );
    }

    public function processChargeBackPayment()
    {
        $this->transactionRepo->place(
            $this->transactionTypeRepo->getChargeBackType(),
            $this->amountInSenderWalletCurrency,
            $this->getAmountOrigin(),
            $this->senderWallet
        );
    }

    protected function initAmountInReceiverWalletCurrency()
    {
        $this->amountInReceiverWalletCurrency = $this->receiverWallet->currency_code !== $this->getPaymentCurrency() ?
            $this->currencyFromOriginConverter->convert($this->receiverWallet->currency_code, $this->getAmountOrigin()) :
            $this->getAmount();
    }

    protected function initAmountInSenderWalletCurrency()
    {
        $this->amountInSenderWalletCurrency = $this->senderWallet->currency_code !== $this->getPaymentCurrency() ?
            $this->currencyFromOriginConverter->convert($this->senderWallet->currency_code, $this->getAmountOrigin()) :
            $this->getAmount();
    }


    protected function checkIsEnoughBalance(string $currencyTo, string $userWalletName, string $amount)
    {
        $this->senderWallet;
        $originAmountTo = $this->currencyToOriginConverter->convert($currencyTo, $amount);
        $balanceOrigin = $this->currencyToOriginConverter->convert(
            $this->senderWallet->currency_code,
            $this->senderWallet->balance
        );
        if ((string)$originAmountTo > (string)$balanceOrigin) {
            throw new NotEnoughMoneyException;
        }
    }
}