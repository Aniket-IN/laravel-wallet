<?php

namespace AniketIN\Wallet\Models;

use AniketIN\Wallet\Round;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AniketIN\Wallet\Casts\Round;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'ob',
        'cb',
        'description',
        'type',
    ];

    protected $casts = [
        'ob' => Round::class,
        'cb' => Round::class,
        'amount' => Round::class,
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
