# Autodiscovering PSR-17 HTTP Factories

[![Latest Version](https://img.shields.io/packagist/v/tuupola/http-factory.svg?style=flat-square)](https://packagist.org/packages/tuupola/http-factory)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/tuupola/http-factory/master.svg?style=flat-square)](https://travis-ci.org/tuupola/http-factory)
[![Coverage](https://img.shields.io/codecov/c/github/tuupola/http-factory.svg?style=flat-square)](https://codecov.io/github/tuupola/http-factory)

## Install

Install the library using [Composer](https://getcomposer.org/).

``` bash
$ composer require tuupola/http-factory
```
## Usage

Let's assume you have Diactoros installed.

```
$ composer require zendframework/zend-diactoros
```

The factories will now automatically return Diactoros PSR-7 instances.

```php
use Tuupola\Http\Factory\RequestFactory;

$request = (new RequestFactory)->createRequest("GET", "https://example.com/");
print get_class($request); /* Zend\Diactoros\Request */
```

On the other hand if you have Slim frameworks installed.

```
$ composer remove zendframework/zend-diactoros
$ composer require slim/slim
```

The factories will now return Slim PSR-7 instances.

```php
use Tuupola\Http\Factory\RequestFactory;

$request = (new RequestFactory)->createRequest("GET", "https://example.com/");
print get_class($request); /* Slim\Http\Request */
```

This library currently automatically detects and supports [zendframework/zend-diactoros](https://github.com/zendframework/zend-diactoros), [slim/slim](https://github.com/slimphp/slim), [nyholm/psr7](https://github.com/Nyholm/psr7) and  [guzzle/psr7](https://github.com/guzzle/psr7) PSR-7 implementations.

## Testing

You can run tests either manually or automatically on every code change. Automatic tests require [entr](http://entrproject.org/) to work.

``` bash
$ make test
```
``` bash
$ brew install entr
$ make watch
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email tuupola@appelsiini.net instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.