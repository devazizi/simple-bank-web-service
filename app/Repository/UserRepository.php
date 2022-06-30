<?php

namespace App\Repository;

use App\Infrastructure\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\CreditCard;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getUserPhoneNumberByCellNumber(string $creditCardNumber)
    {
        return CreditCard::query()
            ->select('users.phone_number')
            ->where('credit_card_number', $creditCardNumber)
            ->join('accounts', 'accounts.id', '=', 'credit_cards.account_id')
            ->join('users', 'users.id', '=', 'accounts.user_id')
            ->first()->phone_number;
    }
}
