<?php

arch('source classes use strict types or valid PHP')
    ->expect('pxlrbt\LaravelPdfable')
    ->toBeClasses()
    ->ignoring([
        'pxlrbt\LaravelPdfable\Concerns',
        'pxlrbt\LaravelPdfable\Layout\PageSize',
        'pxlrbt\LaravelPdfable\Layout\PageOrientation',
        'pxlrbt\LaravelPdfable\Drivers\Driver',
    ]);

arch('concerns are traits')
    ->expect('pxlrbt\LaravelPdfable\Concerns')
    ->toBeTraits();

arch('enums are enums')
    ->expect('pxlrbt\LaravelPdfable\Layout\PageSize')
    ->toBeEnum();

arch('driver interface is an interface')
    ->expect('pxlrbt\LaravelPdfable\Drivers\Driver')
    ->toBeInterface();

arch('drivers implement the Driver interface')
    ->expect('pxlrbt\LaravelPdfable\Drivers\BrowsershotDriver')
    ->toImplement('pxlrbt\LaravelPdfable\Drivers\Driver');
