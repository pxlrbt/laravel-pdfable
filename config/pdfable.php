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

    // Configure browsershot driver
    'browsershot' => [
        // Customize path to Google Chrome's binary
        'chrome_path' => null,

        // Set optional arguments for chrome. All of these arguments
        // will automatically be prefixed with --
        'chromium_arguments' => [],

        // Define other puppeteer options
        'options' => [
            'headless' => 'new',
        ],

        // Set path to node binary if it is not in $PATH
        'node_binary' => null,

        // Set path to NPM binary if it is not in $PATH
        'npm_binary' => null,

        // If you want to use an alternative node_modules source you can
        // set it here by specifying path to your node_modules directory.
        'node_modules_path' => null,

        // If you don't want to manually specify binary paths,
        // but rather modify the include path in general, you can
        // set it here e.g. 'include_path' => '$PATH:/usr/local/bin'
        'include_path' => null,
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
