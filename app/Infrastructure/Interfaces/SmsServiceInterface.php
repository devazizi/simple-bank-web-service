<?php

namespace App\Infrastructure\Interfaces;

interface SmsServiceInterface
{
    public function sendSms(string $phoneNumber, string $message);
}
