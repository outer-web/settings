<?php

declare(strict_types=1);

namespace Outerweb\Settings;

use Outerweb\Settings\Services\Setting;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('settings')
            ->hasConfigFile()
            ->hasMigrations([
                'create_settings_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('outer-web/settings');
            });
    }

    public function boot(): void
    {
        parent::boot();

        $this->app->singleton('setting', function () {
            return new Setting;
        });
    }
}
