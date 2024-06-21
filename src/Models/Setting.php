<?php

namespace Outerweb\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Outerweb\Settings\SettingRegistar;

class Setting extends Model
{

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(string $key = '*', mixed $default = null): mixed
    {
        $settings = cache()->rememberForever(app(SettingRegistar::class)->cacheKey, function () {
            $settings = [];

            Setting::all()->each(function ($setting) use (&$settings) {
                data_set($settings, $setting->key, $setting->value);
            });

            return $settings;
        });

        if ($key === '*') {
            return $settings;
        }

        return data_get($settings, $key, $default);
    }

    public static function set(string $key, mixed $value): mixed
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        cache()->forget(app(SettingRegistar::class)->cacheKey);

        return $setting->value;
    }

    public function getTable(): string
    {
        return config('settings.database_table_name', 'settings');
    }
}
