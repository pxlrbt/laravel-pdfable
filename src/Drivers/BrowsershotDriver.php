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

        $browser = Browsershot::html($html)
            ->paperSize($page->getWidth(), $page->getHeight())
            ->margins(...$page->getMargins());

        // Configure browsershot
        if (filled(config('pdfable.browsershot.chrome_path'))) {
            $browser->setChromePath(
                config('pdfable.browsershot.chrome_path')
            );
        }

        if (filled(config('pdfable.browsershot.chromium_arguments'))) {
            $browser->addChromiumArguments(
                config('pdfable.browsershot.chromium_arguments')
            );
        }

        if (filled(config('pdfable.browsershot.node_binary'))) {
            $browser->setNodeBinary(
                config('pdfable.browsershot.node_binary')
            );
        }

        if (filled(config('pdfable.browsershot.npm_binary'))) {
            $browser->setNpmBinary(
                config('pdfable.browsershot.npm_binary')
            );
        }

        if (filled(config('pdfable.browsershot.include_path'))) {
            $browser->setIncludePath(
                config('pdfable.browsershot.include_path')
            );
        }

        if (filled(config('pdfable.browsershot.node_modules_path'))) {
            $browser->setNodeModulePath(
                config('pdfable.browsershot.node_modules_path')
            );
        }

        if (filled(config('pdfable.browsershot.options'))) {
            collect(config('pdfable.browsershot.options'))
                ->each(
                    fn ($item, $key) => $browser->setOption($key, $item)
                );
        }

        return base64_decode(
            $browser->base64pdf()
        );
    }
}
