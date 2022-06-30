<?php

namespace App\Infrastructure\Interfaces\Repositories;

interface AccountManagementRepositoryInterface
{
    public function checkCreditCardBelongToUser(string $creditCardNumber, $ownerId);

    public function hasEnoughBalanceInAccountCheckThroughCreditCard(string $creditCardNumber, int $requiredBalance);

    public function decreaseBalance(string $creditCardNumber, string $amount);

    public function increaseBalance(string $creditCardNumber, string $amount);

}
