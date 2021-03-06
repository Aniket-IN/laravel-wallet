<?php

namespace AniketIN\Wallet\Traits;

use AniketIN\Wallet\Models\Wallet;

trait HasWallet
{
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'walletable')->withDefault(function ($wallet, $user) {
            return $user->wallet()->lockForUpdate()->firstOrCreate([
                'balance' => 0,
                'withdrawable_balance' => 0,
            ]);
        })->lockForUpdate();
    }
}
