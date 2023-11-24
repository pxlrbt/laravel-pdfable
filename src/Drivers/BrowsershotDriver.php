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

        // Configure browsershot instance
        $this->configureBrowsershot($browser);

        return base64_decode(
            $browser->base64pdf()
        );
    }

    protected function configureBrowsershot(Browsershot $browserShot)
    {
        if (filled(config('pdfable.browsershot.chrome_path'))) {
            $browserShot->setChromePath(
                config('pdfable.browsershot.chrome_path')
            );
        }

        if (filled(config('pdfable.browsershot.chromium_arguments'))) {
            $browserShot->addChromiumArguments(
                config('pdfable.browsershot.chromium_arguments')
            );
        }

        if (filled(config('pdfable.browsershot.node_binary'))) {
            $browserShot->setNodeBinary(
                config('pdfable.browsershot.node_binary')
            );
        }

        if (filled(config('pdfable.browsershot.npm_binary'))) {
            $browserShot->setNpmBinary(
                config('pdfable.browsershot.npm_binary')
            );
        }

        if (filled(config('pdfable.browsershot.include_path'))) {
            $browserShot->setIncludePath(
                config('pdfable.browsershot.include_path')
            );
        }

        if (filled(config('pdfable.browsershot.node_modules_path'))) {
            $browserShot->setNodeModulePath(
                config('pdfable.browsershot.node_modules_path')
            );
        }

        if (filled(config('pdfable.browsershot.options'))) {
            collect(config('pdfable.browsershot.options'))
                ->each(
                    fn ($item, $key) => $browserShot->setOption($key, $item)
                );
        }
    }
}
