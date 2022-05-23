<?php

namespace AniketIN\Wallet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'ob',
        'cb',
        'description',
        'type',
    ];

    protected $casts = [
        'ob' => 'float',
        'cb' => 'float',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
