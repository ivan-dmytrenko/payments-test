<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Country;
use App\Models\CurrencyUsdRate;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\UserWallet;
use App\Payment\Charge;
use App\Payments\Deposit;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CurrencyUsdRateRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionTypeRepository;
use App\Repositories\UserWalletRepository;
use App\Validators\TransactionValidator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CurrencyRepository;
use App\Models\Currency;
use App\Payments\Converter\CurrencyToOrigin;
use App\Payments\Converter\CurrencyFromOrigin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->validator->resolver(function($translator, $data, $rules, $messages, $customAttributes) {
            return new TransactionValidator(
                $translator,
                $data,
                $rules,
                $messages,
                $customAttributes,
                $this->app->get('App\Repositories\Contracts\UserWalletRepositoryInterface')
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Repositories\Contracts\CurrencyRepositoryInterface', function () {
            $repo = new CurrencyRepository(new Currency());
            return $repo;
        });

        $this->app->singleton('App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface', function () {
            $repo = new CurrencyUsdRateRepository(new CurrencyUsdRate());
            return $repo;
        });

        $this->app->singleton('App\Repositories\Contracts\UserWalletRepositoryInterface', function () {
            $repo = new UserWalletRepository(new UserWallet());
            return $repo;
        });

        $this->app->singleton('App\Repositories\Contracts\CountryRepositoryInterface', function () {
            $repo = new CountryRepository(new Country());
            return $repo;
        });

        $this->app->singleton('App\Repositories\Contracts\CityRepositoryInterface', function () {
            $repo = new CityRepository(new City());
            return $repo;
        });

        $this->app->singleton('App\Repositories\Contracts\TransactionTypeRepositoryInterface', function () {
            $repo = new TransactionTypeRepository(new TransactionType());
            return $repo;
        });

        $this->app->bind('App\Repositories\Contracts\TransactionRepositoryInterface', function () {
            $repo = new TransactionRepository(new Transaction());
            return $repo;
        });

        $this->app->singleton('App\Payments\Converter\CurrencyToOrigin', function () {
            return new CurrencyToOrigin($this->app->get('App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface'));
        });

        $this->app->singleton('App\Payments\Converter\CurrencyFromOrigin', function () {
            return new CurrencyFromOrigin($this->app->get('App\Repositories\Contracts\CurrencyUsdRateRepositoryInterface'));
        });

        $this->app->bind('App\Payments\Contracts\DepositInterface', function () {
            return new Deposit(
                $this->app->get('App\Repositories\Contracts\UserWalletRepositoryInterface'),
                $this->app->get('App\Payments\Converter\CurrencyToOrigin'),
                $this->app->get('App\Payments\Converter\CurrencyFromOrigin'),
                $this->app->get('App\Repositories\Contracts\TransactionTypeRepositoryInterface'),
                $this->app->get('App\Repositories\Contracts\TransactionRepositoryInterface')
            );
        });

        $this->app->bind('App\Payments\Contracts\ChargeInterface', function () {
            return new Charge(
                $this->app->get('App\Repositories\Contracts\UserWalletRepositoryInterface'),
                $this->app->get('App\Payments\Converter\CurrencyToOrigin'),
                $this->app->get('App\Payments\Converter\CurrencyFromOrigin'),
                $this->app->get('App\Repositories\Contracts\TransactionTypeRepositoryInterface'),
                $this->app->get('App\Repositories\Contracts\TransactionRepositoryInterface')
            );
        });
    }
}
