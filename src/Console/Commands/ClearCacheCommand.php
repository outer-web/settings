<?php

namespace Outerweb\Settings\Console\Commands;

use Illuminate\Console\Command;

class ClearCacheCommand extends Command
{
    protected $signature = 'settings:clear-cache';

    protected $description = 'Clear the settings cache.';

    public function handle()
    {
        cache()->forget(config('settings.cache_key'));

        $this->info('Settings cache cleared.');

        return Command::SUCCESS;
    }
}
