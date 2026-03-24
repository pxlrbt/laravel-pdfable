<?php

use Illuminate\Mail\Attachment;
use pxlrbt\LaravelPdfable\Pdfable;

it('creates a mail attachment', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'laravel-pdfable::base';

        public function filename(): string
        {
            return 'invoice.pdf';
        }
    };

    $attachment = $pdf->toMailAttachment();

    expect($attachment)->toBeInstanceOf(Attachment::class);
});
