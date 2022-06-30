<?php

namespace App\Infrastructure\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function getUserPhoneNumberByCellNumber(string $creditCardNumber);
}
