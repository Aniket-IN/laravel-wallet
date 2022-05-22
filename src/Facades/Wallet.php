<?php

namespace AniketIN\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AniketIN\Wallet\Wallet
 */
class Wallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-wallet';
    }
}
