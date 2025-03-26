<?php

namespace Outerweb\Settings\Tests;

use Outerweb\Settings\Models\Setting;

class CommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    /** @test */
    public function it_can_cache_settings_with_command()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        cache()->forget(config('settings.cache_key')); // Clear cache
        
        // Act
        $this->artisan('settings:cache')
            ->assertSuccessful()
            ->expectsOutput('Settings cached.');
        
        // Assert
        $this->assertTrue(cache()->has(config('settings.cache_key')));
    }
    
    /** @test */
    public function it_can_clear_cache_with_command()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        Setting::get('test_key'); // Cache the settings
        $this->assertTrue(cache()->has(config('settings.cache_key')));
        
        // Act
        $this->artisan('settings:clear-cache')
            ->assertSuccessful()
            ->expectsOutput('Settings cache cleared.');
        
        // Assert
        $this->assertFalse(cache()->has(config('settings.cache_key')));
    }
}