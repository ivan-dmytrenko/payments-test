<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Repository;
use App\Repositories\Contracts\CurrencyRepositoryInterface;

class CurrencyRepository extends Repository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $currencyModel)
    {
        $this->model = $currencyModel;
    }
}