<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance', 'account_number'];

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }
}
