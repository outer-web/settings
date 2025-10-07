![Settings](./docs/images/github-banner.png)

# Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/outerweb/settings.svg?style=flat-square)](https://packagist.org/packages/outerweb/settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/outerweb/settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/outer-web/settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/outerweb/settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/outer-web/settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/outerweb/settings.svg?style=flat-square)](https://packagist.org/packages/outerweb/settings)

This package provides application wide settings stored in your database

## Table of Contents

-   [Installation](#installation)
-   [Usage](#usage)
-   [Changelog](#changelog)
-   [License](#license)

## Installation

You can install the package via composer:

```bash
composer require outerweb/settings
```

## Usage

This package tries to mimic the Config functionality of Laravel as close as possible.

You can use the `Outerweb\Settings\Facades\Setting` facade or the `setting()` helper function to work with your stored settings.

### Storing settings

#### Storing a single setting

```php
use Outerweb\Settings\Facades\Setting;

Setting::set('key', 'value');
// or
setting(['key' => 'value']);
// or
setting()->set('key', 'value');
```

#### Storing multiple settings

```php
use Outerweb\Settings\Facades\Setting;

Setting::set([
    'key1' => 'value1',
    'key2' => 'value2',
]);
// or
setting([
    'key1' => 'value1',
    'key2' => 'value2',
]);
// or
setting()->set([
    'key1' => 'value1',
    'key2' => 'value2',
]);
```

#### Storing nested settings

You can use "dot" notation to store nested settings:

```php
use Outerweb\Settings\Facades\Setting;

Setting::set('parent.child', 'value');
// or
setting(['parent.child' => 'value']);
// or
setting()->set('parent.child', 'value');
```

This will store a single table entry with the key `parent.child` and the value `value`.

You can also store nested settings using arrays:

```php
use Outerweb\Settings\Facades\Setting;

Setting::set([
    'parent' => [
        'child1' => 'value',
        'child2' => 'value',
    ],
]);
// or
setting([
    'parent' => [
        'child1' => 'value',
        'child2' => 'value',
    ],
]);
// or
setting()->set([
    'parent' => [
        'child1' => 'value',
        'child2' => 'value',
    ],
]);
```

This will store two table entries:

-   `parent.child1` with the value `value`
-   `parent.child2` with the value `value`

### Retrieving settings

#### Retrieving a single setting

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::get('key');
// or
$value = setting('key');
// or
$value = setting()->get('key');
```

This will return the value of the setting stored with the key `key`. If the setting does not exist, it will return `null`.

You can also provide a default value that will be returned if the setting does not exist:

```php
$value = Setting::get('key', 'default_value');
// or
$value = setting('key', 'default_value');
// or
$value = setting()->get('key', 'default_value');
```

This will return `default_value` if the setting with the key `key` is null or does not exist.

#### Retrieving a nested setting

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::get('parent.child');
// or
$value = setting('parent.child');
// or
$value = setting()->get('parent.child');
```

This will return the value of the setting stored with the key `parent.child`.

#### Retrieving multiple settings via parent key

Imagine you have the following settings stored:

-   `parent.child1` with the value `value1`
-   `parent.child2` with the value `value2`

```php
use Outerweb\Settings\Facades\Setting;

$values = Setting::get('parent');
// or
$values = setting('parent');
// or
$values = setting()->get('parent');
```

This will return an associative array:

```php
[
    'child1' => 'value1',
    'child2' => 'value2',
]
```

#### Retrieving multiple settings

```php
use Outerweb\Settings\Facades\Setting;

$values = Setting::get(['parent.child1', 'parent.child2']);
// or
$values = setting(['parent.child1', 'parent.child2']);
// or
$values = setting()->get(['parent.child1', 'parent.child2']);
```

This will return an associative array:

```php
[
    'parent.child1' => 'value1',
    'parent.child2' => 'value2',
]
```

#### Retrieving all settings

```php
use Outerweb\Settings\Facades\Setting;

$values = Setting::get();
// or
$values = setting()->get();
```

This will return all settings as an associative array.

### Type safety

You can use the following methods to ensure type safety when retrieving settings:

#### String

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::string('key');
// or
$value = setting()->string('key');
```

This will make sure the returned value is a string. Otherwise, it will throw an `UnexpectedValueException`.

#### Integer

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::integer('key');
// or
$value = setting()->integer('key');
```

This will make sure the returned value is an integer. Otherwise, it will throw an `UnexpectedValueException`.

#### Float

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::float('key');
// or
$value = setting()->float('key');
```

This will make sure the returned value is a float. Otherwise, it will throw an `UnexpectedValueException`.

#### Boolean

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::boolean('key');
// or
$value = setting()->boolean('key');
```

This will make sure the returned value is a boolean. Otherwise, it will throw an `UnexpectedValueException`.

#### Array

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::array('key');
// or
$value = setting()->array('key');
```

This will make sure the returned value is an array. Otherwise, it will throw an `UnexpectedValueException`.

#### Collection

```php
use Outerweb\Settings\Facades\Setting;

$value = Setting::collection('key');
// or
$value = setting()->collection('key');
```

This uses the same logic as `array()` but returns a `Illuminate\Support\Collection` instance instead of an array.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
