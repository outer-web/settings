<?php

declare(strict_types=1);

use Outerweb\Settings\Facades\Setting as SettingFacade;
use Outerweb\Settings\Models\Setting as SettingModel;

describe('casts', function (): void {
    it('casts the value attribute to json', function (): void {
        SettingFacade::set([
            'string' => 'hello world!',
            'integer' => 123,
            'float' => 3.14,
            'boolean' => true,
            'array' => ['foo' => 'bar'],
        ]);

        expect(SettingFacade::get('string'))->toBe('hello world!');
        expect(SettingFacade::get('integer'))->toBe(123);
        expect(SettingFacade::get('float'))->toBe(3.14);
        expect(SettingFacade::get('boolean'))->toBe(true);
        expect(SettingFacade::get('array'))->toBe(['foo' => 'bar']);
    });
});

describe('methods', function (): void {
    it('uses the table defined in the config', function (?string $configTable): void {
        if (! is_null($configTable)) {
            config()->set('settings.database.table', $configTable);
        }

        expect(new SettingModel()->getTable())->toBe($configTable ?? 'settings');
    })
        ->with([
            'default' => [null],
            'custom' => ['custom_settings_table'],
        ]);
});
