<?php

namespace Outerweb\Settings\Tests;

use Outerweb\Settings\Models\Setting;

class SettingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    /** @test */
    public function it_can_store_a_setting()
    {
        // Act
        $result = Setting::set('test_key', 'test_value');
        
        // Assert
        $this->assertEquals('test_value', $result);
        $this->assertDatabaseHas('settings', [
            'key' => 'test_key',
        ]);
    }
    
    /** @test */
    public function it_can_retrieve_a_setting()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        
        // Act
        $result = Setting::get('test_key');
        
        // Assert
        $this->assertEquals('test_value', $result);
    }
    
    /** @test */
    public function it_can_retrieve_all_settings()
    {
        // Arrange
        Setting::set('test_key1', 'test_value1');
        Setting::set('test_key2', 'test_value2');
        
        // Act
        $result = Setting::get();
        
        // Assert
        $this->assertIsArray($result);
        $this->assertEquals('test_value1', $result['test_key1']);
        $this->assertEquals('test_value2', $result['test_key2']);
    }
    
    /** @test */
    public function it_returns_default_value_when_setting_not_found()
    {
        // Act
        $result = Setting::get('non_existent_key', 'default_value');
        
        // Assert
        $this->assertEquals('default_value', $result);
    }
    
    /** @test */
    public function it_can_update_an_existing_setting()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        
        // Act
        $result = Setting::set('test_key', 'updated_value');
        
        // Assert
        $this->assertEquals('updated_value', $result);
        $this->assertEquals('updated_value', Setting::get('test_key'));
    }
    
    /** @test */
    public function it_can_store_complex_data_types()
    {
        // Arrange
        $complexData = [
            'key1' => 'value1',
            'key2' => 2,
            'key3' => true,
            'key4' => [
                'nested' => 'value'
            ]
        ];
        
        // Act
        Setting::set('complex_key', $complexData);
        $result = Setting::get('complex_key');
        
        // Assert
        $this->assertEquals($complexData, $result);
    }
    
    /** @test */
    public function it_caches_settings()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        
        // Act - Get the value which should cache it
        Setting::get('test_key');
        
        // Assert - Check if the cache key exists
        $this->assertTrue(cache()->has(config('settings.cache_key')));
    }
    
    /** @test */
    public function it_clears_cache_when_setting_is_updated()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        Setting::get('test_key'); // Cache the settings
        
        // Act
        Setting::set('test_key', 'updated_value');
        
        // Assert - Cache should be cleared and recreated on next get
        $cachedSettings = cache()->get(config('settings.cache_key'));
        $this->assertNull($cachedSettings);
        
        // Getting again should recreate the cache
        Setting::get('test_key');
        $this->assertTrue(cache()->has(config('settings.cache_key')));
    }
}