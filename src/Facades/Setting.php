<?php

declare(strict_types=1);

namespace Outerweb\Settings\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Outerweb\Settings\Services\Setting as SettingService;

/**
 * @method bool has(string $key)
 * @method mixed get(string|array|null $key, mixed $default = null)
 * @method array getMany(array $keys)
 * @method string string(string $key, string $default = null)
 * @method int integer(string $key, int $default = null)
 * @method float float(string $key, float $default = null)
 * @method bool boolean(string $key, bool $default = null)
 * @method array array(string $key, array $default = null)
 * @method Collection collection(string $key, array|Collection $default = null)
 * @method void set(string|array $key, mixed $value = null)
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
