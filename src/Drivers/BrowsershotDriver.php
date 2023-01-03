<?php

namespace pxlrbt\LaravelPdfable\Drivers;

use pxlrbt\LaravelPdfable\Pdfable;
use Spatie\Browsershot\Browsershot;

class BrowsershotDriver implements Driver
{
    public function getData(Pdfable $pdf): ?string
    {
        $html = $pdf->getView()->render();
        $page = $pdf->page();

        return base64_decode(
            Browsershot::html($html)
                ->paperSize($page->getWidth(), $page->getHeight())
                ->margins(...$page->getMargins())
                ->base64pdf()
        );
    }
}
