<?php

namespace Outerweb\Settings\Console\Commands;

use Illuminate\Console\Command;

class CacheCommand extends Command
{
    protected $signature = 'settings:cache';

    protected $description = 'Clear the settings cache.';

    public function handle()
    {
        cache()->rememberForever(config('settings.cache_key'), function () {
            return \Outerweb\Settings\Models\Setting::get('*');
        });

        $this->info('Settings cached.');

        return Command::SUCCESS;
    }
}
