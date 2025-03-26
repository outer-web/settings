<?php

namespace Outerweb\Settings\Tests;

use Outerweb\Settings\Models\Setting;

class HelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    /** @test */
    public function it_can_get_a_setting_using_helper()
    {
        // Arrange
        Setting::set('test_key', 'test_value');
        
        // Act
        $result = setting('test_key');
        
        // Assert
        $this->assertEquals('test_value', $result);
    }
    
    /** @test */
    public function it_can_set_a_setting_using_helper_with_array()
    {
        // Arrange
        $settings = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        
        // Act
        $result = setting($settings);
        
        // Assert
        $this->assertEquals('value1', $result['key1']);
        $this->assertEquals('value2', $result['key2']);
        $this->assertEquals('value1', setting('key1'));
        $this->assertEquals('value2', setting('key2'));
    }
    
    /** @test */
    public function it_returns_default_value_when_setting_not_found_using_helper()
    {
        // Act
        $result = setting('non_existent_key', 'default_value');
        
        // Assert
        $this->assertEquals('default_value', $result);
    }
    
    /** @test */
    public function it_can_get_all_settings_using_helper()
    {
        // Arrange
        setting([
            'key1' => 'value1',
            'key2' => 'value2',
        ]);
        
        // Act
        $result = setting();
        
        // Assert
        $this->assertIsArray($result);
        $this->assertEquals('value1', $result['key1']);
        $this->assertEquals('value2', $result['key2']);
    }
    
    /** @test */
    public function it_can_set_and_get_nested_settings_using_helper()
    {
        // Arrange & Act
        setting([
            'parent.child1' => 'value1',
            'parent.child2' => 'value2',
        ]);
        
        // Assert
        $this->assertEquals('value1', setting('parent.child1'));
        $this->assertEquals('value2', setting('parent.child2'));
        
        $parent = setting('parent');
        $this->assertIsArray($parent);
        $this->assertEquals('value1', $parent['child1']);
        $this->assertEquals('value2', $parent['child2']);
    }
}