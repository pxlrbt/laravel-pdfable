<?php

namespace pxlrbt\LaravelPdfable\Drivers;

use pxlrbt\LaravelPdfable\Pdfable;
use Spatie\Browsershot\Browsershot;

class BrowsershotDriver implements Driver
{
    protected static $configurator = null;

    public static function configureBrowsershot(callable $configurator): void {
        static::$configurator = $configurator;
    }

    public function getData(Pdfable $pdf): ?string
    {
        $html = $pdf->getView()->render();
        $page = $pdf->page();

        $browser = Browsershot::html($html)
            ->paperSize($page->getWidth(), $page->getHeight())
            ->margins(...$page->getMargins());

        // Configure browsershot instance
        if (isset(self::$configurator)) {
            $browser = call_user_func(self::$configurator, $browser);
        }

        return base64_decode(
            $browser->base64pdf()
        );
    }
}
