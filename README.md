# Shared utilities for developing the Conquest PHP ecosystem.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/conquest/core.svg?style=flat-square)](https://packagist.org/packages/conquest/core)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jdw5/conquest-core/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jdw5/conquest-core/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jdw5/conquest-core/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jdw5/conquest-core/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/conquest/core.svg?style=flat-square)](https://packagist.org/packages/conquest/core)

Conquest Core is a package from shareable traits and the Primitive object used across all Conquest packages.

## Installation

You can install the package via composer:

```bash
composer require conquest/core
```

## Usage
Extend a class using the `Primitive` object to then use the traits provided to add functionality to your classes simply. The `Primitive` object is designed for serialization to be sent over wire.

```php
use Conquest\Core\Primitive;

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
