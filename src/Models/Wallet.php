<?php

namespace AniketIN\Wallet\Models;

use AniketIN\Wallet\Casts\Round;
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

    protected $casts = [
        'balance' => Round::class,
        'withdrawable_balance' => Round::class,
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
            $wallet = $this->lockForUpdate()->find($this->id);

            $transaction['ob'] = $wallet->balance;

            $this->update([
                'balance' => $wallet->balance + $amount,
            ]);

            return $this->transactions()->create([
                ...$transaction,
                'type' => 'credit',
                'amount' => $amount,
                'cb' => $this->balance,
                'description' => $description,
            ]);
        });
    }

    public function withdraw(int $amount, string $description, bool $force = false, $bypass_withdrawable_limit = false)
    {
        if ($amount < 1) {
            throw new Exception("Withdrawl amount must not be less than 1, $amount given.");
        }

        return DB::transaction(function () use ($amount, $description, $force, $bypass_withdrawable_limit) {
            $wallet = $this->lockForUpdate()->find($this->id);

            $transaction['ob'] = $wallet->balance;

            if ($wallet->balance < $amount && ! $force) {
                throw new Exception("To withdraw more than wallet balance you need to use force mode.");
            }

            if ($wallet->withdrawable_balance < $amount && ! $bypass_withdrawable_limit) {
                throw new Exception("Withdrawable balance exceeds! Max withdrawable limit is set to {$wallet->withdrawable_balance}.");
            }

            $this->update([
                'balance' => $wallet->balance - $amount,
                'withdrawable_balance' => $bypass_withdrawable_limit ? $wallet->withdrawable_balance : $wallet->withdrawable_balance - $amount,
            ]);

            return $this->transactions()->create([
                ...$transaction,
                'type' => 'debit',
                'amount' => $amount,
                'cb' => $this->balance,
                'description' => $description,
            ]);
        });
    }
}
