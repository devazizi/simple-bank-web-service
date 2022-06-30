<?php

namespace App\Infrastructure\Interfaces\Repositories;

interface TransactionRepositoryInterface
{
    public function storeTransactionLog(string $from, string $to, int $amount);

    public function storeTransactionFee(int $transactionId, int $fee);

    public function getThreeUserHaveMostTransaction();
}
