<?php

namespace App\Service;

use App\Constants\TransactionConstants;
use App\Infrastructure\Interfaces\Repositories\AccountManagementRepositoryInterface;
use App\Infrastructure\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Repository\AccountManagementRepository;
use App\Repository\TransactionRepository;
use Illuminate\Support\Facades\DB;

class CardTransactionService
{
    public static function createTransaction(array $requestData)
    {
        /* @var $accountManagementRepo AccountManagementRepository */
        $accountManagementRepo = app(AccountManagementRepositoryInterface::class);
        /* @var $transactionRepo TransactionRepository*/
        $transactionRepo = app(TransactionRepositoryInterface::class);

        DB::transaction(function () use ($requestData, $accountManagementRepo, $transactionRepo) {

            $accountManagementRepo->decreaseBalance(
                $requestData['from'],
                $requestData['amount'] + TransactionConstants::TRANSACTION_FEE
            );

            $senderTransaction = $transactionRepo->storeTransactionLog(
                $requestData['from'],
                $requestData['to'],
                $requestData['amount'] + TransactionConstants::TRANSACTION_FEE
            );

            $transactionRepo->storeTransactionFee(
                $senderTransaction->id,
                TransactionConstants::TRANSACTION_FEE
            );

            $accountManagementRepo->increaseBalance(
                $requestData['to'],
                $requestData['amount']
            );

        });
    }
}
