<?php

use pxlrbt\LaravelPdfable\Drivers\Driver;
use pxlrbt\LaravelPdfable\Drivers\WkhtmltopdfDriver;

it('implements the Driver interface', function () {
    expect(WkhtmltopdfDriver::class)->toImplement(Driver::class);
});
