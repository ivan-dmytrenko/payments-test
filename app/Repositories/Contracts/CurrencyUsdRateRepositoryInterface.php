<?php

namespace App\Repositories\Contracts;

use App\Models\Currency;

interface CurrencyUsdRateRepositoryInterface extends RepositoryInterface
{
    public function createWithAssociation(array $input, Currency $currency);

    public function getRateForToday(string $currencyCode);
}