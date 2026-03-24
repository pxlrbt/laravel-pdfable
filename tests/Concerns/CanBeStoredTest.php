<?php

use Illuminate\Support\Facades\Storage;
use pxlrbt\LaravelPdfable\Drivers\Driver;
use pxlrbt\LaravelPdfable\Pdfable;

it('returns default filename', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->filename())->toBe('default.pdf');
});

it('allows overriding filename', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public function filename(): string
        {
            return 'custom.pdf';
        }
    };

    expect($pdf->filename())->toBe('custom.pdf');
});

it('sets disk via fluent method', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    $result = $pdf->disk('s3');

    expect($result)->toBeInstanceOf(Pdfable::class);
});

it('saves pdf to storage', function () {
    Storage::fake('local');

    $driver = Mockery::mock(Driver::class);
    $driver->shouldReceive('getData')->once()->andReturn('pdf-content');

    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public function filename(): string
        {
            return 'test.pdf';
        }
    };

    app()->instance(get_class($driver), $driver);
    config(['pdfable.drivers.browsershot' => get_class($driver)]);

    $result = $pdf->save();

    expect($result)->toBeInstanceOf(Pdfable::class);
    Storage::disk('local')->assertExists('test.pdf');
});

it('saves pdf with custom filename', function () {
    Storage::fake('local');

    $driver = Mockery::mock(Driver::class);
    $driver->shouldReceive('getData')->once()->andReturn('pdf-content');

    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    app()->instance(get_class($driver), $driver);
    config(['pdfable.drivers.browsershot' => get_class($driver)]);

    $pdf->save('custom-name.pdf');

    Storage::disk('local')->assertExists('custom-name.pdf');
});

it('saves pdf to specific disk', function () {
    Storage::fake('s3');

    $driver = Mockery::mock(Driver::class);
    $driver->shouldReceive('getData')->once()->andReturn('pdf-content');

    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    app()->instance(get_class($driver), $driver);
    config(['pdfable.drivers.browsershot' => get_class($driver)]);

    $pdf->disk('s3')->save('test.pdf');

    Storage::disk('s3')->assertExists('test.pdf');
});
