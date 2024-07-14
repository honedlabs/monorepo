# Create backend-driven charts with a fluent interface.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/conquest/chart.svg?style=flat-square)](https://packagist.org/packages/conquest/chart)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jdw5/conquest-chart/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jdw5/conquest-chart/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/conquest/chart/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jdw5/conquest-chart/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/conquest/chart.svg?style=flat-square)](https://packagist.org/packages/conquest/chart)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require conquest/chart
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="chart-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="chart-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$chart = new Conquest\Chart();
```

## Testing

```bash
composer test
```

## Credits

- [Joshua Wallace](https://github.com/jdw5)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
