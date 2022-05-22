<?php

namespace AniketIN\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'balance',
        'withdrawable_balance',
    ];

    public function walletable()
    {
        return $this->morphTo();
    }
}
