<?php

namespace AniketIN\Wallet\Commands;

use Illuminate\Console\Command;

class WalletCommand extends Command
{
    public $signature = 'laravel-wallet';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
