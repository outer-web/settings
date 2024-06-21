<?php

namespace Outerweb\Settings;

class SettingRegistar
{
    public string $cacheKey;

    public function __construct()
    {
        $this->cacheKey = config('settings.cache_key');
    }
}