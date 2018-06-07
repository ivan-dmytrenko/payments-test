<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;

class CityRepository extends Repository implements CityRepositoryInterface
{
    public function __construct(City $cityModel)
    {
        $this->model = $cityModel;
    }
}