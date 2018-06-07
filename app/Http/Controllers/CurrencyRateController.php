<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRate;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CurrencyRateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCurrencyRate $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreCurrencyRate $request,
        CurrencyUsdRateRepositoryInterface $currencyUsdRateRepo,
        CurrencyRepositoryInterface $currencyRepo
    ) {
        $currency = $currencyRepo->firstOrCreate(['code' => $request->get('currency_code')]);
        $currencyUsdRateRepo->createWithAssociation($request->only(['rate', 'date']), $currency);

        return response()->json('', JsonResponse::HTTP_CREATED);
    }
}