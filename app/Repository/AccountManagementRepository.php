<?php

namespace App\Repository;

use App\Infrastructure\Interfaces\Repositories\AccountManagementRepositoryInterface;
use App\Models\Account;
use App\Models\CreditCard;

class AccountManagementRepository implements AccountManagementRepositoryInterface
{

    public function checkCreditCardBelongToUser(string $creditCardNumber, $ownerId)
    {
        $creditCard = CreditCard::query()
            ->select('account_id')
            ->where('credit_card_number', $creditCardNumber)
            ->firstOrFail();

        Account::query()->where('user_id', $ownerId)->findOrFail($creditCard->account_id);
    }

    public function hasEnoughBalanceInAccountCheckThroughCreditCard(string $creditCardNumber, int $requiredBalance)
    {
        return CreditCard::query()
            ->whereHas('account', function ($query) use ($requiredBalance) {
                $query->where('balance', '>=', $requiredBalance);
            })->where('credit_card_number', $creditCardNumber)->exists();
    }

    public function decreaseBalance(string $creditCardNumber, string $amount)
    {
        $creditCard = CreditCard::query()->select('account_id')
            ->where('credit_card_number', $creditCardNumber)
            ->firstOrFail();

        $account = Account::query()->where('id', $creditCard->account_id)->firstOrFail();
        $account->update(['balance' => $account->balance - $amount]);
    }

    public function increaseBalance(string $creditCardNumber, string $amount)
    {
        $creditCard = CreditCard::query()->select('account_id')
            ->where('credit_card_number', $creditCardNumber)
            ->firstOrFail();

        $account = Account::query()->where('id', $creditCard->account_id)->firstOrFail();

        $account->update(['balance' => $account->balance + $amount]);
    }
}
