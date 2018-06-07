<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserWallet;
use App\Http\Requests\UpdateUserWallet;
use App\Payments\Contracts\DepositInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use App\Repositories\Contracts\UserWalletRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserWalletController extends Controller
{
    protected $userWalletRepo;

    public function __construct(UserWalletRepositoryInterface $userWalletRepo)
    {
        $this->userWalletRepo = $userWalletRepo;
    }

    public function store(
        StoreUserWallet $request,
        CountryRepositoryInterface $countryRepo,
        CityRepositoryInterface $cityRepo,
        CurrencyRepositoryInterface $currencyRepo
    )
    {
        $country = $countryRepo->firstOrCreate(['name' => $request->get('country')]);
        $city = $cityRepo->firstOrCreate(['name' => $request->get('city')]);

        $this->userWalletRepo->createWithAssociation(
            $request->only('name'),
            $country,
            $city,
            $currencyRepo->find($request->get('currency_code'))
        );

        return response()->json('', JsonResponse::HTTP_CREATED);
    }

    public function update(UpdateUserWallet $request, DepositInterface $deposit)
    {
        try {
            $deposit->prepare($request->get('name'), $request->get('amount'));
            $deposit->processDeposit();
        } catch (\Exception $e) {
            return response()->json('', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json('', JsonResponse::HTTP_OK);
    }
}
