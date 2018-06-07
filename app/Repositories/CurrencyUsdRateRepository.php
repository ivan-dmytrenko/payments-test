<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\CurrencyUsdRate;
use App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface;
use DateTime;

class CurrencyUsdRateRepository extends Repository implements  CurrencyUsdRateRepositoryInterface
{
    public function __construct(CurrencyUsdRate $currencyUsdRateModel)
    {
        $this->model = $currencyUsdRateModel;
    }

    public function createWithAssociation(array $input, Currency $currency)
    {
        $this->fill($input);
        $this->model->currency()->associate($currency);
        $this->model->save();
    }

    public function getRateForToday(string $currencyCode)
    {
        $dateTime = new DateTime();
        $todayDate = $dateTime->format('Y-m-d');
        return $this->where([['currency_code', $currencyCode], ['date', $todayDate]]);
    }
}