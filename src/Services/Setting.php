<?php

declare(strict_types=1);

namespace Outerweb\Settings\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Outerweb\Settings\Models\Setting as SettingModel;

class Setting
{
    public function has(string $key): bool
    {
        return $this->model()::query()
            ->where('key', $key)
            ->orWhere('key', 'like', $key.'.%')
            ->exists();
    }

    public function get(string|array|null $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $this->model()::query()->get()->mapWithKeys(function (SettingModel $item) {
                return [$item->key => $item->value];
            })
                ->undot()
                ->toArray();
        }

        if (is_array($key)) {
            return $this->getMany($key);
        }

        $results = $this->model()::query()
            ->where('key', $key)
            ->orWhere('key', 'like', $key.'.%')
            ->get();

        if ($results->isEmpty()) {
            return $default;
        }

        if ($results->count() === 1 && $results->first()->key === $key) {
            return $results->first()->value;
        }

        return $results->mapWithKeys(function (SettingModel $item) use ($key) {
            return [Str::after($item->key, "{$key}.") => $item->value];
        })
            ->undot()
            ->toArray();
    }

    public function getMany(array $keys): array
    {
        $results = $this->model()::query()
            ->whereIn('key', $keys)
            ->orWhere(function (Builder $query) use ($keys) {
                foreach ($keys as $key) {
                    $query->orWhere('key', 'like', $key.'.%');
                }
            })
            ->get();

        if ($results->isEmpty()) {
            return [];
        }

        return $results->mapWithKeys(function (SettingModel $item) {
            return [$item->key => $item->value];
        })
            ->undot()
            ->toArray();
    }

    /**
     * @param  (\Closure():(string|null))|string|null  $default
     */
    public function string(string $key, mixed $default = null): string
    {
        $value = $this->get($key, $default);

        if (! is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('Setting value for key [%s] must be a string, %s given.', $key, gettype($value))
            );
        }

        return $value;
    }

    /**
     * @param  (\Closure():(int|null))|int|null  $default
     */
    public function integer(string $key, mixed $default = null): int
    {
        $value = $this->get($key, $default);

        if (! is_int($value)) {
            throw new InvalidArgumentException(
                sprintf('Setting value for key [%s] must be an integer, %s given.', $key, gettype($value))
            );
        }

        return $value;
    }

    /**
     * @param  (\Closure():(float|null))|float|null  $default
     */
    public function float(string $key, mixed $default = null): float
    {
        $value = $this->get($key, $default);

        if (! is_float($value) && ! is_int($value)) {
            throw new InvalidArgumentException(
                sprintf('Setting value for key [%s] must be a float, %s given.', $key, gettype($value))
            );
        }

        return (float) $value;
    }

    /**
     * @param  (\Closure():(bool|null))|bool|null  $default
     */
    public function boolean(string $key, mixed $default = null): bool
    {
        $value = $this->get($key, $default);

        if (! is_bool($value)) {
            throw new InvalidArgumentException(
                sprintf('Setting value for key [%s] must be a boolean, %s given.', $key, gettype($value))
            );
        }

        return $value;
    }

    /**
     * @param  (\Closure():(array<array-key, mixed>|null))|array<array-key, mixed>|null  $default
     * @return array<array-key, mixed>
     */
    public function array(string $key, mixed $default = null): array
    {
        $value = $this->get($key, $default);

        if (! is_array($value)) {
            throw new InvalidArgumentException(
                sprintf('Setting value for key [%s] must be an array, %s given.', $key, gettype($value))
            );
        }

        return $value;
    }

    /**
     * @param  (\Closure():(array<array-key, mixed>|null))|array<array-key, mixed>|null  $default
     * @return Collection<array-key, mixed>
     */
    public function collection(string $key, mixed $default = null): Collection
    {
        return Collection::make($this->array($key, $default));
    }

    public function set(array|string $key, mixed $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];
        $keys = Arr::dot($keys);

        foreach ($keys as $key => $value) {
            $this->model()::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    public function model(): string
    {
        return Config::string('settings.model', SettingModel::class);
    }
}
