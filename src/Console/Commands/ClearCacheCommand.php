<?php

namespace Outerweb\Settings\Console\Commands;

use Illuminate\Console\Command;
use Outerweb\Settings\SettingRegistar;

class ClearCacheCommand extends Command
{
    protected $signature = 'settings:clear-cache';

    protected $description = 'Clear the settings cache.';

    public function handle()
    {
        cache()->forget(app(SettingRegistar::class)->cacheKey);

        $this->info('Settings cache cleared.');

        return Command::SUCCESS;
    }
}
