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
php artisan vendor:publish --tag="pdfable-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="pdfable-views"
```

## Configuration

Currently two drivers are supported:

- Browsershot (default)
- Wkhtmltopdf (legacy, wkhtmltopdf is deprecated)

### Browsershot Driver

This is the default driver and requires [spatie/browsershot](https://github.com/spatie/browsershot). Please follow the installation instructions for that package.

You can configure the Browsershot driver via `BrowsershotDriver::configureUsing()` in your `AppServiceProvider`:

```php
BrowsershotDriver::configureUsing(
    fn (Browsershot $browser) => $browser->setCustomTempPath(storage_path('tmp'));
});
```

### Wkhtmltopdf Driver

To use the wkhtmlpdf Driver, make sure `wkhtmltopdf` is installed on your system and globally available.

Then, set the `PDFABLE_DRIVER` option in  your `.env` file to `wkhtmltopdf`.


## Generating Pdfables

You can use the make command to generate a Pdfable class and view.

```shell

php artisan make:pdf Invoice

```

## Usage

You can directly use, pass or return Pdfables in many places in your app.

### As Files

You can store Pdfables via `->store()` method. This will use `outputFile()` method on the class to determine the class name. Optionally, you can pass a custom filename.

```php
(new Invoice($order)->store()));
```

### As Responses

You can either stream, download or return your Pdfables HTML for debugging.

#### HTML

To return HTML in a debugging view, just return the Pdfable.

```php
Route::get('/invoice/{order}', fn (Order $order) => new Invoice($order));
```

#### Stream

To stream your Pdfable, add the `->stream()` method.

```php
Route::get('/invoice/{order}', fn (Order $order) => (new Invoice($order)->stream()));
```

#### Download

To download your Pdfable, add the `->download()` method. Optionally, you can also override the filename from here.

```php
Route::get('/invoice/{order}', fn (Order $order) => (new Invoice($order)->download('custom-filename.pdf')));
```

### As Mailable Attachment

To use a Pdfable as a mail attachment, just pass it via `->attach()`. Make sure your mailables/notifications are queued for faster processing.

```php
return (new MailMessage)
    ->subject("Your Invoice")    
    ->attach(new Invoice($order));
```

### As Jobs

Pdfs can take some time to create, so you can queue your Pdfables and create them in the background with the known Laravel methods.

```php
dispatch(new Invoice($order));
// or
Invoice::dispatch($order);
// ...
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

Pass additional data via the constructor of your Pdfable for later use.

```php
public function __construct(
    public Order $order,
    public ?Customer $customer = null,
)
{}
```

### Accessing Data From View

Similar to Laravel's Blade Components you can access properties and public methods directly from your view file.

```html
<h1>Invoice for Order {{ $order->id }}</h1>

<div>Total: {{ $getTotal() }}</div>  
```

### Configuring The Output File

When saving a Pdfable to the disk, you can provide a default path via `filename()` and override the default disk via `$disk` property. 

```php
public function filename(): string
{
    return "customers/{$this->customer->id}/{$this->order->id}.pdf";
}
```

### Queuing A Pdfable

Pdfables implement `ShouldQueue` and therefore can be pushed to a queue via `Invoice::dispatch()`. You can also use other queue configuration methods directly on your Pdfable like `backoff()`, `retryUntil()`, `uniqueId()`, ...

## Credits

- [Dennis Koch](https://github.com/pxlrbt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
