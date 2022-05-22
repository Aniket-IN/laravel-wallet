<?php

namespace AniketIN\Wallet\Traits;

use AniketIN\Wallet\Models\Wallet;

trait HasWallet
{
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'walletable')->withDefault(function ($wallet, $user) {
            $wallet->balance = 0;
            $wallet->withdrawable_balance = 0;
            $user->wallet()->save($wallet);
        });
    }
}
