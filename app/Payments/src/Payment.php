<?php

namespace App\Payments;

use App\Payments\Converter\CurrencyToOrigin;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserWalletRepositoryInterface;
use App\Payments\Converter\CurrencyFromOrigin;
use App\Repositories\TransactionTypeRepository;

class Payment
{
    const ORIGINAL_CURRENCY = 'USD';

    const AMOUNT_PRECISION = 2;

    private $wallet;

    private $walletCurrency;

    private $paymentCurrency;

    private $amount;

    private $amountInOrigin;

    protected $currencyFromOriginConverter;

    protected $currencyToOriginConverter;

    protected $userWalletRepo;

    protected $transactionTypeRepo;

    protected $transactionRepo;

    public function __construct(
        UserWalletRepositoryInterface $userWalletRepo,
        CurrencyToOrigin $currencyToOrigin,
        CurrencyFromOrigin $currencyFromOrigin,
        TransactionTypeRepository $transactionTypeRepo,
        TransactionRepositoryInterface $transactionRepo
    )
    {
        $this->userWalletRepo = $userWalletRepo;
        $this->currencyToOriginConverter = $currencyToOrigin;
        $this->currencyFromOriginConverter = $currencyFromOrigin;
        $this->transactionTypeRepo = $transactionTypeRepo;
        $this->transactionRepo = $transactionRepo;
    }

    protected function initWallet(string $senderName)
    {
        $this->wallet = $this->userWalletRepo->getWithBalance($senderName);
        $this->walletCurrency = $this->wallet->currency_code;
    }

    protected function initPaymentCurrency(string $currency)
    {
        $this->paymentCurrency = $currency;
    }

    protected function initAmounts(string $amount)
    {
        $this->amount = $amount;
        $this->amountInOrigin = $this->currencyToOriginConverter->convert(
            $this->paymentCurrency,
            $amount
        );
    }

    protected function getWallet()
    {
        return $this->wallet;
    }

    protected function getWalletCurrency()
    {
        return $this->walletCurrency;
    }

    protected function getAmount()
    {
        return $this->amount;
    }

    protected function getAmountOrigin()
    {
        return $this->amountInOrigin;
    }

    protected function getPaymentCurrency()
    {
        return $this->paymentCurrency;
    }
}