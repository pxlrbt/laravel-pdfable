<?php

use pxlrbt\LaravelPdfable\Pdfable;

it('sets preview to true when rendering', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->preview)->toBeFalse();

    $pdf->render();

    expect($pdf->preview)->toBeTrue();
});

it('returns display filename from full path', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public function filename(): string
        {
            return 'invoices/2024/invoice-123.pdf';
        }
    };

    expect($pdf->displayFilename())->toBe('invoice-123.pdf');
});

it('returns default filename when not overridden', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';
    };

    expect($pdf->displayFilename())->toBe('default.pdf');
});
