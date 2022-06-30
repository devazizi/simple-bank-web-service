<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creditCards = [
            [
                'id' => 1,
                'account_id' => 1,
                'credit_card_number' => '6104337649766126',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'account_id' => 1,
                'credit_card_number' => '6104337649746126',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'account_id' => 1,
                'credit_card_number' => '6104337649763124',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'account_id' => 1,
                'credit_card_number' => '6104337649726124',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($creditCards as $creditCard) {
            CreditCard::query()->create($creditCard);
        }
    }
}
