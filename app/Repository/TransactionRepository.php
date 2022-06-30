<?php

namespace App\Repository;

use App\Infrastructure\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Models\TransactionFee;
use App\Models\User;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function storeTransactionLog(string $from, string $to, int $amount)
    {
        return Transaction::query()->create([
            'from' => $from,
            'to' => $to,
            'amount' => $amount
        ]);
    }

    public function storeTransactionFee(int $transactionId, int $fee)
    {
        TransactionFee::query()->create([
            'transaction_id' => $transactionId,
            'fee' => $fee
        ]);
    }

    private function getUsersTransactions(array $usersId)
    {
        return User::query()
            ->with(['accounts.creditCards' => function ($query) {
                $query->join('transactions', function ($join) {
                    $join->on('credit_cards.credit_card_number', '=', 'transactions.from')
                        ->orOn('credit_cards.credit_card_number', '=', 'transactions.to');
                })->where('transactions.created_at', '>=', now()->addMinute(-40));
            }])
            ->whereIn('users.id', $usersId)->get();
    }

    public function getThreeUserHaveMostTransaction()
    {
        $usersIdHaveMustTransactions = User::query()
            ->select('users.id as userId')
            ->selectRaw('count(users.id) as transactionCount')
            ->join('accounts', 'accounts.user_id', '=', 'users.id')
            ->join('credit_cards', 'credit_cards.account_id', '=', 'accounts.id')
            ->join('transactions', function ($join) {
                $join->on('credit_cards.credit_card_number', '=', 'transactions.from')
                    ->orOn('credit_cards.credit_card_number', '=', 'transactions.to');
            })
            ->where('transactions.created_at', '>=', now()->addMinute(-40))
            ->groupBy('users.id')
            ->orderBy('transactionCount', 'desc')
            ->limit(3)->get()->pluck('userId')->toArray();

        return $this->getUsersTransactions($usersIdHaveMustTransactions);

    }
}
