<?php

if (!function_exists('setting')) {
    function setting(string|array $key = '*', mixed $default = null): mixed
    {
        if (is_array($key)) {
            $settings = [];

            foreach ($key as $k => $v) {
                data_set($settings, $k, \Outerweb\Settings\Models\Setting::set($k, $v));
            }

            return $settings;
        }

        return \Outerweb\Settings\Models\Setting::get($key, $default);
    }
}
