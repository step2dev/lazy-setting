# Lazy setting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/step2dev/lazy-setting.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-setting)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/step2dev/lazy-setting/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/step2dev/lazy-setting/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/step2dev/lazy-setting/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/step2dev/lazy-setting/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/step2dev/lazy-setting.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-setting)

This package provides a flexible way to manage application settings in Laravel. It includes caching, input validation, and a simple API with support for static methods via a facade.

## Features

- Easily get and set application settings.
- Support for caching settings to improve performance.
- Input validation for settings.
- Simple API with static method support through a facade.

## Installation

You can install the package via composer:

```bash
composer require step2dev/lazy-setting
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="lazy-setting-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="lazy-setting-config"
```

[//]: # (This is the contents of the published config file:)

[//]: # ()
[//]: # (```php)

[//]: # (return [)

[//]: # (];)

[//]: # (```)

[//]: # (Optionally, you can publish the views using)

[//]: # ()
[//]: # (```bash)

[//]: # (php artisan vendor:publish --tag="lazy-setting-views")

[//]: # (```)

## Usage

```php
$lazySetting = new Step2Dev\LazySetting();
echo $lazySetting->echoPhrase('Hello, Step2Dev!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [CrazyBoy49z](https://github.com/CrazyBoy49z)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
