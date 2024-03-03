# Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/outerweb/settings.svg?style=flat-square)](https://packagist.org/packages/outerweb/settings)
[![Total Downloads](https://img.shields.io/packagist/dt/outerweb/settings.svg?style=flat-square)](https://packagist.org/packages/outerweb/settings)

This package adds application wide settings stored in your database.

## Installation

You can install the package via composer:

```bash
composer require outerweb/settings
```

Run the install command:

```bash
php artisan settings:install
```

## Usage

### Saving settings

You can save settings using the helper function `setting()`:

```php
setting(['key' => 'value']);
```

You can also save multiple settings at once:

```php
setting([
    'general.key1' => 'value1',
    'general.key2' => 'value2',
]);

// Returns
[
    'general.key1' => 'value1',
    'general.key2' => 'value2',
]
```

### Retrieving settings

You can retrieve settings using the helper function `setting()`:

```php
setting(string $key, mixed $default = null);

// Example
setting('key', 'default');

// Returns
'value' // or 'default' if the key does not exist
```

The key can be a dot-notation key to retrieve nested settings:

```php
setting('general.key1');

// Returns
'value1'
```

If you have multiple settings with the same parent key, you can retrieve them all at once:

```php
setting('general');

// Returns
[
    'key1' => 'value1',
    'key2' => 'value2',
]
```

You can also retrieve all settings at once:

```php
setting('*');

// Returns
[
    'key' => 'value',
    'general' => [
        'key1' => 'value1',
        'key2' => 'value2',
    ],
]
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Simon Broekaert](https://github.com/SimonBroekaert)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
