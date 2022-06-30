<?php

namespace App\Service\SMS;

use App\Infrastructure\Interfaces\SmsServiceInterface;
use Kavenegar\KavenegarApi;
use Illuminate\Support\Facades\Log;

class Kavenegar implements SmsServiceInterface
{
    private function callAPI(string $phoneNumber, string $message)
    {
        $kApi = new KavenegarApi(env('kavehnegar_api_key'));
        Log::info($kApi->Send(config('sms.kavenegar_sender'), $phoneNumber, $message));
    }

    public function sendSms(string $phoneNumber, string $message)
    {
        // TODO: Implement sendSms() method.
    }
}
