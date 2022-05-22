<?php

namespace AniketIN\Wallet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AniketIN\Wallet\Commands\WalletCommand;

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
            ->hasMigration('create_laravel-wallet_table')
            ->hasCommand(WalletCommand::class);
    }
}
