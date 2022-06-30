<?php

namespace App\Service\SmsPattern;

class CardTransactionSMSPattern
{
    public static function sender(array $data)
    {
        return trans('messages.decrease_transaction_sms_message', [
            'cardNumber' => $data['cardNumber'],
            'amount' => $data['amount']
        ]);
    }

    public static function receiver(array $data)
    {
        return trans('messages.increase_transaction_sms_message', [
            'cardNumber' => $data['cardNumber'],
            'amount' => $data['amount']
        ]);
    }
}
