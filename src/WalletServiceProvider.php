<?php

namespace AniketIN\Wallet;

use AniketIN\Wallet\Commands\WalletCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WalletServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wallet')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_wallets_table', 'create_wallet_transactions_table'])
            ->hasCommand(WalletCommand::class);
    }
}
