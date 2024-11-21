# Honed Core

[![Latest Version on Packagist](https://img.shields.io/packagist/v/honed/core.svg?style=flat-square)](https://packagist.org/packages/honed/core)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/core/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/honedlabs/core/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/honedlabs/core/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/honedlabs/core/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/honed/core.svg?style=flat-square)](https://packagist.org/packages/honed/core)

Honed Core is a package of sharable traits and the `Primitive` object used across all the Honed package ecosystem to handle serialization and other core functionality.

## Installation

You can install the package via composer:

```bash
composer require honed/core
```

## Usage
Extend a class using the `Primitive` object to then use the traits provided to add functionality to your classes simply. The `Primitive` object is designed for serialization to be sent over wire.

```php
use Honed\Core\Primitive;

class MyClass extends Primitive
{
    use ...;
    
    public class toArray(): array
    {
        return [];
    }
}
```

## Testing

```bash
composer test
```

## Credits

- [Joshua Wallace](https://github.com/jdw5)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
