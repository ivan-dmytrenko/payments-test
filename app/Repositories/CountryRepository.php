<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;

class CountryRepository extends Repository implements CountryRepositoryInterface
{
    public function __construct(Country $countryModel)
    {
        $this->model = $countryModel;
    }
}