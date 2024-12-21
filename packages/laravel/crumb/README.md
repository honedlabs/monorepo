# Generate and share breadcrumbs to your Inertia applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/honed/crumb.svg?style=flat-square)](https://packagist.org/packages/honed/crumb)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/crumb/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/honedlabs/crumb/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/crumb/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/honedlabs/crumb/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/honed/crumb.svg?style=flat-square)](https://packagist.org/packages/honed/crumb)


## Installation

You can install the package via composer:

```bash
composer require honed/crumb
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="crumb-config"
```

This is the contents of the published config file:

```php
return [
    'files' => base_path('routes/crumbs.php'),
];
```

## Usage

Within a controller, you can define a set of crumbs and pass them to your frontend application

```php
Trail::make(
    Crumb::make('Home', '/'),
    Crumb::make('About', '/about'),
);
```

You can also define a global set of crumbs, and then set them for a specific route

```php
Trail::for('home', function (Trail $trail) {
    $trail->push(Crumb::make('Home', '/'));
});
```

These can be automatically resolved on a controller by using the `Crumbs` trait, and then defining the crumb name as an attribute, property of method on the Controller class.

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

- [Joshua Wallace](https://github.com/jdw5)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
