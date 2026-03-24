<?php

use Illuminate\Support\Facades\Storage;
use pxlrbt\LaravelPdfable\Drivers\Driver;
use pxlrbt\LaravelPdfable\Pdfable;

it('saves pdf when handled as a job', function () {
    Storage::fake('local');

    $driver = Mockery::mock(Driver::class);
    $driver->shouldReceive('getData')->once()->andReturn('pdf-content');

    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public function filename(): string
        {
            return 'queued.pdf';
        }
    };

    app()->instance(get_class($driver), $driver);
    config(['pdfable.drivers.browsershot' => get_class($driver)]);

    $pdf->handle();

    Storage::disk('local')->assertExists('queued.pdf');
});
