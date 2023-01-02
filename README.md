# Laravel Pdfable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pxlrbt/laravel-pdfable.svg?style=flat-square)](https://packagist.org/packages/pxlrbt/laravel-pdfable)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pxlrbt/laravel-pdfable/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pxlrbt/laravel-pdfable/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pxlrbt/laravel-pdfable/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pxlrbt/laravel-pdfable/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pxlrbt/laravel-pdfable.svg?style=flat-square)](https://packagist.org/packages/pxlrbt/laravel-pdfable)

Keep the logic for your PDFs in one place like you do with Laravel's Mailables.

## Installation

You can install the package via composer:

```bash
composer require pxlrbt/laravel-pdfable
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-pdfable-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-pdfable-views"
```

## Configuration

Currently two drivers are supported:

- Browsershot (default)
- Wkhtmltopdf (legacy, wkhtmltopdf is deprecated)

### Browsershot Driver

This is the  driver and requires [spatie/browsershot](https://github.com/spatie/browsershot). Please follow the installation instructions for that package.

### Wkhtmltopdf Driver

To use the wkhtmlpdf Driver, make sure `wkhtmltopdf` is installed on your system and globally available.

Then, set the `PDFABLE_DRIVER` option in  your `.env` file to `wkhtmltopdf`.


## Generating Pdfables
```shell
php artisan make:pdf Invoice
```

## Writing Pdfables

Once you have generated a pdfable class, open it up so we can explore its contents. Pdfable class configuration is done in several methods.

### Configuring The View

The view is configured via static `$view` property.

```php
class Invoice extends Pdfable
{
    public string $view = 'pdf.task';
}
```

### Configuring The Page/Layout

You can return a `Page` object to configure the PDF page size, orientation and margins. 

```php
public function page(): Page
{
    return Page::make()->size(PageSize::A4)->margins('narrow');
}
```

### Passing Additional Data

Pass additional data via the constructor of your `Pdfable` for later use.

```php
public function __construct(
    public Customer $cusomter,
    public ?Order $order = null
)
{}
```
### Configuring The Output File

When saving a `Pdfable` to the disk, you can provide a default path via `outputFile()`. 

```php
public function outputFile(): string
{
    return "customers/{$this->customer->id}/{$this->order->id}.pdf";
}
```

### Queuing A Pdfable

`Pdfable`s implement `ShouldQueue` and therefore can be pushed to a queue via `Invoice::dispatch()`. You can also use other queue configuration methods directly on your `Pdfable` like `backoff()`, `retryUntil()`, `uniqueId()`, ...



## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dennis Koch](https://github.com/pxlrbt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
