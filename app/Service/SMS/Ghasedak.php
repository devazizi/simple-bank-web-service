<?php

namespace App\Service\SMS;

use App\Infrastructure\Interfaces\SmsServiceInterface;
use Ghasedak\GhasedakApi;
use Illuminate\Support\Facades\Http;

class Ghasedak implements SmsServiceInterface
{
    private function callAPI(string $phoneNumber, string $message)
    {
        $ghasedakAPI = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $ghasedakAPI->SendSimple($phoneNumber, $message);
    }

    public function sendSms(string $phoneNumber, string $message)
    {
        $this->callAPI($phoneNumber, $message);
    }
}
