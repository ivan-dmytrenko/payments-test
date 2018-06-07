<?php
namespace App\Payments\Converter;

use App\Payments\Payment;
use App\Repositories\CurrencyUsdRateRepository;

class CurrencyToOrigin
{
    protected $currencyToUsdRepo;

    public function __construct(CurrencyUsdRateRepository $currencyToUsdRepo)
    {
        $this->currencyToUsdRepo = $currencyToUsdRepo;
    }

    public function convert(string $currencyCode, string $amount)
    {
        if ($currencyCode === Payment::ORIGINAL_CURRENCY) {
            return $amount;
        }

        $rate = $this->currencyToUsdRepo->getRateForToday($currencyCode)->first()->rate;

        return bcmul($amount, $rate, Payment::AMOUNT_PRECISION);
    }
}