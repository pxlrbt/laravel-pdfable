<?php

use pxlrbt\LaravelPdfable\Drivers\BrowsershotDriver;
use pxlrbt\LaravelPdfable\Drivers\WkhtmltopdfAdapter;
use pxlrbt\LaravelPdfable\Layout\PageOrientation;
use pxlrbt\LaravelPdfable\Layout\PageSize;

return [
    'default' => env('PDFABLE_DRIVER', 'browsershot'),

    'drivers' => [
        'browsershot' => BrowsershotDriver::class,
        'wkhtmltopdf' => WkhtmltopdfAdapter::class,
    ],

    'layout' => [
        'defaults' => [
            'page-size' => PageSize::A4,
            'orientation' => PageOrientation::Portrait,
            'margins' => 'moderate',
        ],

        'margins' => [
            'narrow' => [12.7, 12.7, 12.7, 12.7],
            'moderate' => [25.4, 19.05, 25.4, 19.05],
            'wide' => [25.4, 50.8, 25.4, 50.8],
            'none' => [0, 0, 0, 0],
        ],
    ],
];
