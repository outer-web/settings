<?php

namespace Outerweb\Settings\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Outerweb\Settings\SettingsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SettingsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        $mediaTableMigration = require __DIR__.'/../database/migrations/create_settings_table.php.stub';

        $mediaTableMigration->up();
    }
}
