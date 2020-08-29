# Generate download links in your Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/armancodes/laravel-download-link.svg?style=flat-square)](https://packagist.org/packages/armancodes/laravel-download-link)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/armancodes/laravel-download-link/Tests?label=tests)](https://github.com/armancodes/laravel-download-link/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/armancodes/laravel-download-link.svg?style=flat-square)](https://packagist.org/packages/armancodes/laravel-download-link)

This package allows you to generate download links for files.

Once installed you can do stuff like this:

```php
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->generate();
// zkTu70fieUFZLGMoEP95l1RQfFj5zCOqHlM0XBTnc6ZaZTtm4GY5xPXGGLzLEAVe
```

The default download route in the config file is "download", so if your domain is "example.com", then you should use this link:

```
example.com/download/{link}

// For example
example.com/download/zkTu70fieUFZLGMoEP95l1RQfFj5zCOqHlM0XBTnc6ZaZTtm4GY5xPXGGLzLEAVe
```

**Note:** You should replace `{link}` with the generated link.

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

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Download Route
    |--------------------------------------------------------------------------
    |
    | Download route will be added to your app URL for using download links.
    | E.g. if your app URL is "example.com", then if your set the download route to
    | "download" it will be "example.com/download/{link}".
    |
    */
    'download_route' => 'download',
];
```

## Usage

You can explicitly set the file name to be saved and downloaded with the given name:

```php
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->fileName('new-text.txt')->generate();
```

Expire time can also be added, so that the link will only be available before it expires:

```php
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->expire(now()->addDay())->generate();
```

You can also specify if only authenticated users or guests should be able to use the link:

 ```php
// Authenticated users only
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->auth()->generate();

// Guests only
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->guest()->generate();
 ```

You may put one or more ip addresses into a blacklist (Download links won't work with those ip addresses):

```php
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->limitIp('127.0.0.1')->generate();

$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->limitIp(['127.0.0.1', '127.0.0.2', '127.0.0.3'])->generate();
```

Or you may put one or more ip addresses into whitelist (Download links will ONLY work with those ip addresses):

```php
$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->allowIp('127.0.0.1')->generate();

$link = DownloadLink::disk('public')->filePath('uploads/test.txt')->allowIp(['127.0.0.1', '127.0.0.2', '127.0.0.3'])->generate();
```

The default download route in the config file is "download", so if your domain is "example.com", then you should use this link to download:

```
example.com/download/{link}

// For example
example.com/download/zkTu70fieUFZLGMoEP95l1RQfFj5zCOqHlM0XBTnc6ZaZTtm4GY5xPXGGLzLEAVe
```

**Note:** You should replace `{link}` with the generated link.

You can delete a link like this:

```php
DownloadLink::delete('link');

// For example
DownloadLink::delete('zkTu70fieUFZLGMoEP95l1RQfFj5zCOqHlM0XBTnc6ZaZTtm4GY5xPXGGLzLEAVe');
```

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
