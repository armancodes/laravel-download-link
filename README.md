# Generate download links in your Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/armancodes/laravel-download-link.svg?style=flat-square)](https://packagist.org/packages/armancodes/laravel-download-link)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/armancodes/laravel-download-link/run-tests?label=tests)](https://github.com/armancodes/laravel-download-link/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/armancodes/laravel-download-link.svg?style=flat-square)](https://packagist.org/packages/armancodes/laravel-download-link)



## Installation

You can install the package via composer:

```bash
composer require armancodes/laravel-download-link
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Armancodes\DownloadLink\DownloadLinkServiceProvider" --tag="migrations"

php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Armancodes\DownloadLink\DownloadLinkServiceProvider" --tag="config"
```

## Usage



## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email me@armancodes.com instead of using the issue tracker.

## Credits

- [Arman Ahmadi](https://github.com/armancodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
