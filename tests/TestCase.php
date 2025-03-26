<?php

namespace Outerweb\Settings\Tests;

use Outerweb\Settings\SettingsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Make sure the config is loaded
        $this->app['config']->set('settings.database_table_name', 'settings');
        $this->app['config']->set('settings.cache_key', 'settings_');
        
        // Create the settings table
        $migrationFile = include __DIR__ . '/../database/migrations/create_settings_table.php.stub';
        $migrationFile->up();
    }

    protected function getPackageProviders($app)
    {
        return [
            SettingsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        
        // Perform any additional environment setup
    }
}