<?php

namespace pxlrbt\LaravelPdfable;

use pxlrbt\LaravelPdfable\Commands\MakeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PdfableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-pdfable')
            ->hasConfigFile()
            ->hasCommand(MakeCommand::class)
            ->hasViewComponent('base', 'base')
            ->hasViews('laravel-pdfable');
    }
}
