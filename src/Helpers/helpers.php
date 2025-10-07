<?php

declare(strict_types=1);

use Outerweb\Settings\Services\Setting;

// @codeCoverageIgnoreStart
if (! function_exists('setting')) {
    // @codeCoverageIgnoreEnd
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array<string, mixed>|string|null  $key
     * @param  mixed  $default
     * @return ($key is null ? Setting : ($key is string ? mixed : null))
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        return app('setting')->get($key, $default);
    }
}
