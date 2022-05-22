<?php

namespace AniketIN\Wallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
