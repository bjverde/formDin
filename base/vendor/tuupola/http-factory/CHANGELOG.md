# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## [1.1.0](https://github.com/tuupola/http-factory/compare/1.0.3...1.1.0) - 2019-08-07
### Added
- Support for slim/psr7 ([#10](https://github.com/tuupola/http-factory/pull/10)).

## [1.0.3](https://github.com/tuupola/http-factory/compare/1.0.2...1.0.3) - 2019-01-11
### Fixed
- `ServerRequestFactory::createServerRequest()` now honours passed in server params.
- `ResponseFactory::createResponse()` now honours passed in reason phrase.

### Added
- All files now have `declare(strict_types=1)`.

## [1.0.2](https://github.com/tuupola/http-factory/compare/1.0.1...1.0.2) - 2018-12-22
### Fixed
- Corrected provides clause to `psr/http-factory-implementation` in `composer.json`.

## [1.0.1](https://github.com/tuupola/http-factory/compare/1.0.0...1.0.1) - 2018-12-19
### Added
- Added missing provides clause for `psr/http-factory` to `composer.json`.

## [1.0.0](https://github.com/tuupola/http-factory/compare/0.4.2...1.0.0) - 2018-10-12
### Removed
- `ServerRequestFactory::createServerRequestFromArray()` is not part of PSR-17 anymore.
### Added
- Run unit tests also with zendframework/zend-diactoros:^2.0 ([#6](https://github.com/tuupola/http-factory/pull/6)).

## [0.4.2](https://github.com/tuupola/http-factory/compare/0.4.1...0.4.2) - 2018-08-09
### Fixed
- Compatibility issues with stable nyholm/psr7 ([#5](https://github.com/tuupola/http-factory/pull/5)).

## [0.4.1](https://github.com/tuupola/http-factory/compare/0.4.0...0.4.1) - 2018-08-09
### Fixed
- Moved http-interop/http-factory-tests as dev dependency ([#3](https://github.com/tuupola/http-factory/pull/3)).

## [0.4.0](https://github.com/tuupola/http-factory/compare/0.3.0...0.4.0) - 2018-08-02
### Added
- Support for the stable version of PSR-17.

### Changed
- PHP 7.1 is now minimal requirement.

## [0.3.0](https://github.com/tuupola/http-factory/compare/0.2.0...0.3.0) - 2017-07-16
### Added
- Factories for URI, server request and uploaded file.

## [0.2.0](https://github.com/tuupola/http-factory/compare/0.1.1...0.2.0) - 2017-07-15
### Added
- Unit and integration tests for request, response and stream.

## [0.1.1](https://github.com/tuupola/http-factory/compare/0.1.0...0.1.1) - 2017-06-01
### Fixed
- Slim request factory was throwing errors.

## 0.1.0 - 2017-05-30
- Initial release with basic factories.