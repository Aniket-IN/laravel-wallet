<?php

namespace AniketIN\Wallet\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function deposit(int $amount, string $description)
    {
        if ($amount < 1) {
            throw new Exception("Deposit amount must not be less than 1, $amount given.");
        }

        DB::transaction(function () use ($amount, $description) {
            $wallet = $this->lockForUpdate()->find($this->id);

            $transaction['ob'] = $wallet->balance;

            $wallet->increment('balance', $amount);

            $wallet->transactions()->create([
                ...$transaction,
                'type' => 'credit',
                'cb' => $wallet->balance,
                'description' => $description,
            ]);
        });
    }
}
