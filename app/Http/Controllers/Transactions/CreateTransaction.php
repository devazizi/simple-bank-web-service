<?php

namespace App\Http\Controllers\Transactions;

use App\Constants\HttpStatusConstants;
use App\Constants\TransactionConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardTransactionRequest;
use App\Jobs\SendCardTransactionJob;
use App\Service\CardTransactionService;
use App\Service\Responser;
use App\Service\SmsPattern\CardTransactionSMSPattern;
use App\Service\TransactionValidators\CreditCards\CreditCardBelongUserValidation;
use App\Service\TransactionValidators\CreditCards\HasEnoughBalanceForTransactionValidation;

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

        CardTransactionService::createTransaction($requestData);

        $this->dispatch(new SendCardTransactionJob($requestData['from'], CardTransactionSMSPattern::sender([
            'cardNumber' => $requestData['from'],
            'amount' => $requestData['amount'] + TransactionConstants::TRANSACTION_FEE
        ])));
        $this->dispatch(new SendCardTransactionJob($requestData['to'], CardTransactionSMSPattern::receiver([
            'cardNumber' => $requestData['to'],
            'amount' => $requestData['amount']
        ])));

        return response()->json(Responser::success(), HttpStatusConstants::CREATED);
    }

}
