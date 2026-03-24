<?php

use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use pxlrbt\LaravelPdfable\Drivers\Driver;
use pxlrbt\LaravelPdfable\Layout\Page;
use pxlrbt\LaravelPdfable\Pdfable;

it('implements required interfaces', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf)->toBeInstanceOf(Attachable::class)
        ->and($pdf)->toBeInstanceOf(Renderable::class)
        ->and($pdf)->toBeInstanceOf(ShouldQueue::class);
});

it('resolves the configured driver', function () {
    $driver = Mockery::mock(Driver::class);
    app()->instance(get_class($driver), $driver);
    config(['pdfable.drivers.browsershot' => get_class($driver)]);

    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->driver())->toBeInstanceOf(Driver::class);
});

it('returns a Page instance from page()', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->page())->toBeInstanceOf(Page::class);
});

it('has preview disabled by default', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->preview)->toBeFalse();
});

it('returns a view from getView()', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    $view = $pdf->getView();

    expect($view)->toBeInstanceOf(View::class);
});

it('passes data to the view', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public string $title = 'Test PDF';
    };

    $view = $pdf->getView();
    $data = $view->getData();

    expect($data)->toHaveKey('title', 'Test PDF');
});
