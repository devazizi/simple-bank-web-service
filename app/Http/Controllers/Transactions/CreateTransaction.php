<?php

namespace App\Http\Controllers\Transactions;

use App\Constants\HttpStatusConstants;
use App\Constants\TransactionConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardTransactionRequest;
use App\Infrastructure\Interfaces\Repositories\AccountManagementRepositoryInterface;
use App\Infrastructure\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Jobs\SendCardTransactionJob;
use App\Repository\AccountManagementRepository;
use App\Repository\TransactionRepository;
use App\Service\Responser;
use App\Service\SmsPattern\CardTransactionSMSPattern;
use App\Service\TransactionValidators\CreditCards\CreditCardBelongUserValidation;
use App\Service\TransactionValidators\CreditCards\HasEnoughBalanceForTransactionValidation;
use Illuminate\Support\Facades\DB;

class CreateTransaction extends Controller
{
    public function createTransactionFromCardToCard(CardTransactionRequest $cardTransactionRequest)
    {
        $requestData = $cardTransactionRequest->all();

        $validator = new HasEnoughBalanceForTransactionValidation(
            $requestData['from'],
            $requestData['amount']
        );
        $validator->validate();

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

        $this->dispatch(new SendCardTransactionJob(1, CardTransactionSMSPattern::sender([
            'cardNumber' => $requestData['from'],
            'amount' => $requestData['amount']
        ])));
        $this->dispatch(new SendCardTransactionJob(1, CardTransactionSMSPattern::receiver([
            'cardNumber' => $requestData['to'],
            'amount' => $requestData['amount']
        ])));

        return response()->json(Responser::success(), HttpStatusConstants::CREATED);
    }

}
