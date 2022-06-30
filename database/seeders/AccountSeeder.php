<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'id' => 1,
                'user_id' => 1,
                'account_number' => '98765432',
                'balance' => 20000000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'account_number' => '98765442',
                'balance' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'account_number' => '98765642',
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach ($accounts as $account) {
            DB::table('accounts')->insert($account);
        }
    }
}
