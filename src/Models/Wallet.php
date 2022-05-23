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

        return DB::transaction(function () use ($amount, $description) {
            $this->refresh()->lockForUpdate()->find($this->id);

            $transaction['ob'] = $this->balance;

            $this->increment('balance', $amount);
            
            return $this->transactions()->create([
                ...$transaction,
                'type' => 'credit',
                'cb' => $this->balance,
                'description' => $description,
            ]);
        });
    }

    public function withdraw(int $amount, string $description)
    {
        if ($amount < 1) {
            throw new Exception("Withdrawl amount must not be less than 1, $amount given.");
        }


        return DB::transaction(function () use ($amount, $description) {
            $this->refresh()->lockForUpdate()->find($this->id);

            $transaction['ob'] = $this->balance;

            $this->decrement('balance', $amount);
            
            return $this->transactions()->create([
                ...$transaction,
                'type' => 'debit',
                'cb' => $this->balance,
                'description' => $description,
            ]);
        });
    }
}
