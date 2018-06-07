<?php
namespace App\Payments\Converter;


use App\Payments\Payment;
use App\Payments\Contracts\ConvertInterface;
use App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface;

class CurrencyFromOrigin implements ConvertInterface
{
    protected $currencyToUsdRepo;

    public function __construct(CurrencyUsdRateRepositoryInterface $currencyToUsdRepo)
    {
        $this->currencyToUsdRepo = $currencyToUsdRepo;
    }

    public function convert(string $currencyCode, string $amount)
    {
        if ($currencyCode === Payment::ORIGINAL_CURRENCY) {
            return $amount;
        }
        $rate = $this->currencyToUsdRepo->getRateForToday($currencyCode)->first()->rate;
        return bcdiv($amount, $rate, Payment::AMOUNT_PRECISION);
    }
}