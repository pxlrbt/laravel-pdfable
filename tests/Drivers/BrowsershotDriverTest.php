<?php

use pxlrbt\LaravelPdfable\Drivers\BrowsershotDriver;
use pxlrbt\LaravelPdfable\Drivers\Driver;

it('implements the Driver interface', function () {
    expect(BrowsershotDriver::class)->toImplement(Driver::class);
});

it('accepts a configuration callback', function () {
    $called = false;

    BrowsershotDriver::configureUsing(function ($browser) use (&$called) {
        $called = true;

        return $browser;
    });

    // Reset static state
    $reflection = new ReflectionClass(BrowsershotDriver::class);
    $property = $reflection->getProperty('configureUsing');
    $value = $property->getValue(null);

    expect($value)->toBeInstanceOf(Closure::class);

    // Clean up
    $property->setValue(null, null);
});
