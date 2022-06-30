<?php

namespace App\Providers;

use App\Infrastructure\Interfaces\Repositories\AccountManagementRepositoryInterface;
use App\Infrastructure\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Infrastructure\Interfaces\Repositories\UserRepositoryInterface;
use App\Repository\AccountManagementRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );

        $this->app->bind(
            AccountManagementRepositoryInterface::class,
            AccountManagementRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->validations();
    }

    public function validations()
    {
        Validator::extend('validate_credit_card_number', function ($attribute, $value, $parameters, $validator) {
            $value; // is mean idea

            return true;
//            dd($attribute, $value, $parameters, $validator);
        });
    }

}
