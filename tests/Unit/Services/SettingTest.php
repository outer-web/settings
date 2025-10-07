<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Outerweb\Settings\Facades\Setting;
use Outerweb\Settings\Models\Setting as SettingModel;

describe('has()', function () {
    it('returns true if the key exists', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        expect(Setting::has('foo'))->toBeTrue();
    });

    it('returns false if the key does not exist', function () {
        expect(Setting::has('non_existing_key'))->toBeFalse();
    });
});

describe('get()', function () {
    it('returns all settings if no key is provided', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);
        SettingModel::create([
            'key' => 'baz',
            'value' => 'qux',
        ]);

        expect(Setting::get())->toBe([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);
    });

    it('returns the value if the key exists', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        expect(Setting::get('foo'))->toBe('bar');
    });

    it('returns the default value if the key does not exist', function () {
        expect(Setting::get('non_existing_key', 'default_value'))->toBe('default_value');
    });

    it('returns nested settings as an array', function () {
        SettingModel::create([
            'key' => 'parent.child1',
            'value' => 'value1',
        ]);
        SettingModel::create([
            'key' => 'parent.child2',
            'value' => 'value2',
        ]);

        expect(Setting::get('parent'))->toBe([
            'child1' => 'value1',
            'child2' => 'value2',
        ]);
    });

    it('returns multiple settings for an array of keys', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);
        SettingModel::create([
            'key' => 'baz',
            'value' => 'qux',
        ]);
        SettingModel::create([
            'key' => 'non_requested',
            'value' => 'value',
        ]);

        expect(Setting::get(['foo', 'baz']))->toBe([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);
    });

    it('returns an empty array if none of the requested keys exist', function () {
        expect(Setting::get(['non_existing_key1', 'non_existing_key2']))->toBe([]);
    });
});

describe('string()', function () {
    it('makes sure the returned value is a string', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'number',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::string('number');
        } else {
            expect(Setting::string('number'))
                ->toBeString();
        }
    })
        ->with([
            ['test', false],
            ['123', false],
            [123, true],
            ['123.45', false],
            [123.45, true],
            [true, true],
            ['true', false],
            [false, true],
            ['false', false],
            [null, true],
            ['null', false],
            ['', false],
        ]);
});

describe('integer()', function () {
    it('makes sure the returned value is an integer', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'number',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::integer('number');
        } else {
            expect(Setting::integer('number'))
                ->toBeInt();
        }
    })
        ->with([
            ['test', true],
            ['123', true],
            [123, false],
            ['123.45', true],
            [123.45, true],
            [true, true],
            ['true', true],
            [false, true],
            ['false', true],
            [null, true],
            ['null', true],
            ['', true],
        ]);
});

describe('float()', function () {
    it('makes sure the returned value is a float', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'number',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::float('number');
        } else {
            expect(Setting::float('number'))
                ->toBeFloat();
        }
    })
        ->with([
            ['test', true],
            ['123', true],
            [123, false],
            ['123.45', true],
            [123.45, false],
            [true, true],
            ['true', true],
            [false, true],
            ['false', true],
            [null, true],
            ['null', true],
            ['', true],
        ]);
});

describe('boolean()', function () {
    it('makes sure the returned value is a boolean', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'bool',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::boolean('bool');
        } else {
            expect(Setting::boolean('bool'))
                ->toBeBool();
        }
    })
        ->with([
            ['test', true],
            ['123', true],
            [123, true],
            ['123.45', true],
            [123.45, true],
            [true, false],
            ['true', true],
            [false, false],
            ['false', true],
            [null, true],
            ['null', true],
            ['', true],
        ]);
});

describe('array()', function () {
    it('makes sure the returned value is an array', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'arr',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::array('arr');
        } else {
            expect(Setting::array('arr'))
                ->toBeArray();
        }
    })
        ->with([
            ['test', true],
            ['123', true],
            [123, true],
            ['123.45', true],
            [123.45, true],
            [true, true],
            ['true', true],
            [false, true],
            ['false', true],
            [null, true],
            ['null', true],
            ['', true],
            [['item1', 'item2'], false],
            [['key1' => 'value1', 'key2' => 'value2'], false],
            [[], false],
        ]);
});

describe('collection()', function () {
    it('returns the array() result as a collection', function (mixed $value, bool $throwsException) {
        SettingModel::create([
            'key' => 'col',
            'value' => $value,
        ]);

        if ($throwsException) {
            $this->expectException(InvalidArgumentException::class);
            Setting::collection('col');
        } else {
            expect(Setting::collection('col'))
                ->toBeInstanceOf(Collection::class);
        }
    })
        ->with([
            ['test', true],
            ['123', true],
            [123, true],
            ['123.45', true],
            [123.45, true],
            [true, true],
            ['true', true],
            [false, true],
            ['false', true],
            [null, true],
            ['null', true],
            ['', true],
            [['item1', 'item2'], false],
            [['key1' => 'value1', 'key2' => 'value2'], false],
            [[], false],
        ]);
});

describe('set()', function () {
    it('sets the value for the given key', function () {
        Setting::set('foo', 'bar');

        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"bar"',
        ]);
    });

    it('updates the value if the key already exists', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);

        Setting::set('foo', 'new_value');

        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"new_value"',
        ]);
    });

    it('can set multiple values at once using an array', function () {
        Setting::set([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"bar"',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'baz',
            'value' => '"qux"',
        ]);
    });

    it('can update multiple values at once using an array', function () {
        SettingModel::create([
            'key' => 'foo',
            'value' => 'bar',
        ]);
        SettingModel::create([
            'key' => 'baz',
            'value' => 'qux',
        ]);

        Setting::set([
            'foo' => 'new_value1',
            'baz' => 'new_value2',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'foo',
            'value' => '"new_value1"',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'baz',
            'value' => '"new_value2"',
        ]);
    });

    it('can set nested values using dot notation in keys', function () {
        Setting::set('parent.child', 'value');

        $this->assertDatabaseHas('settings', [
            'key' => 'parent.child',
            'value' => '"value"',
        ]);
    });
});
