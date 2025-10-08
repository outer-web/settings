<?php

declare(strict_types=1);

namespace Outerweb\Settings\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Outerweb\Settings\Services\Setting as SettingService;

/**
 * @method static bool has(string $key)
 * @method static mixed get(string|array|null $key = null, mixed $default = null)
 * @method static array getMany(array $keys)
 * @method static string string(string $key, string $default = null)
 * @method static int integer(string $key, int $default = null)
 * @method static float float(string $key, float $default = null)
 * @method static bool boolean(string $key, bool $default = null)
 * @method static array array(string $key, array $default = null)
 * @method static Collection collection(string $key, array|Collection $default = null)
 * @method static void set(string|array $key, mixed $value = null)
 *
 * @see \Outerweb\Settings\Services\Setting
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingService::class;
    }
}
