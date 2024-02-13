<?php

namespace pxlrbt\LaravelPdfable\Drivers;

use Closure;
use pxlrbt\LaravelPdfable\Pdfable;
use Spatie\Browsershot\Browsershot;

class BrowsershotDriver implements Driver
{
    protected static ?Closure $configureUsing = null;

    public static function configureUsing(Closure $callback): void {
        static::$configureUsing = $callback;
    }

    public function getData(Pdfable $pdf): ?string
    {
        $html = $pdf->getView()->render();
        $page = $pdf->page();

        $browser = Browsershot::html($html)
            ->paperSize($page->getWidth(), $page->getHeight())
            ->margins(...$page->getMargins());
        
        if (self::$configureUsing !== null) {
            $browser = call_user_func(static::$configureUsing, $browser);
        }

        return base64_decode(
            $browser->base64pdf()
        );
    }
}
