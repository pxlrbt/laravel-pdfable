<?php

namespace pxlrbt\LaravelPdfable\Drivers;

use pxlrbt\LaravelPdfable\Pdfable;

interface Driver
{
    public function getData(Pdfable $pdf): ?string;
}
