<?php

declare(strict_types=1);

use Outerweb\Settings\Models\Setting as SettingModel;
use Outerweb\Settings\Services\Setting as SettingService;
use Outerweb\Settings\Tests\TestCase;

describe('setting()', function (): void {
    it('returns the Setting service when no arguments are given', function (): void {
        expect(setting())->toBeInstanceOf(SettingService::class);
    });

    it('calls the get method when a string key is given', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        expect(setting('foo'))->toBe('bar');
    });

    it('calls the set method when an array is given', function (): void {
        setting(['foo' => 'bar']);

        /** @var TestCase $this */
        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"bar"',
        ]);
    });

    it('can use the set() method to set a value', function (): void {
        setting()->set('foo', 'bar');

        /** @var TestCase $this */
        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"bar"',
        ]);
    });

    it('can use the get() method to get a value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        expect(setting()->get('foo'))->toBe('bar');
    });

    it('can use the string() method to get a string value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        expect(setting()->string('foo'))->toBe('bar');
    });

    it('can use the integer() method to get an integer value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => 123,
        ]);

        expect(setting()->integer('foo'))->toBe(123);
    });

    it('can use the float() method to get a float value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => 1.23,
        ]);

        expect(setting()->float('foo'))->toBe(1.23);
    });

    it('can use the boolean() method to get a boolean value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => true,
        ]);

        expect(setting()->boolean('foo'))->toBeTrue();
    });

    it('can use the array() method to get an array value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => ['bar', 'baz'],
        ]);

        expect(setting()->array('foo'))->toBe(['bar', 'baz']);
    });

    it('can use the collection() method to get a collection value', function (): void {
        SettingModel::create([
            'key' => 'foo',
            'value' => ['bar', 'baz'],
        ]);

        expect(setting()->collection('foo'))->toBeInstanceOf(\Illuminate\Support\Collection::class);
        expect(setting()->collection('foo')->toArray())->toBe(['bar', 'baz']);
    });
});
