<?php

namespace App\Jobs;

use App\Infrastructure\Interfaces\Repositories\UserRepositoryInterface;
use App\Infrastructure\Interfaces\SmsServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCardTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private int $clientId, private string $message)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* @var $smsServiceProvider SmsServiceInterface */
        $smsServiceProviderClass = config('sms.default_service');

        $smsProvider = new $smsServiceProviderClass();

        $client = app(UserRepositoryInterface::class)->get($this->clientId);

        $smsProvider->sendSms($client->phone_number, $this->message);
    }
}
