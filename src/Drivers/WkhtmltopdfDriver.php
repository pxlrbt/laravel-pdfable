<?php

namespace pxlrbt\LaravelPdfable\Drivers;

use pxlrbt\LaravelPdfable\Layout\Page;
use pxlrbt\LaravelPdfable\Pdfable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class WkhtmltopdfDriver implements Driver
{
    protected Page $page;

    protected Pdfable $pdf;

    protected function getBinaryPath()
    {
        return 'wkhtmltopdf';
    }

    protected function getCommandOptions(): array
    {
        return [
            $this->getBinaryPath(),
            '--disable-smart-shrinking',
            '--page-height', $this->page->getHeight(),
            '--page-width', $this->page->getWidth(),
            '-B', $this->page->getMarginBottom(),
            '-T', $this->page->getMarginTop(),
            '-L', $this->page->getMarginLeft(),
            '-R', $this->page->getMarginRight(),
            '-',
            '-',
        ];
    }

    public function getData(Pdfable $pdf): ?string
    {
        $this->pdf = $pdf;
        $this->page = $pdf->page();

        $process = new Process($this->getCommandOptions());

        $process->setInput($pdf->getView()->render());

        $process->run();

        if ($process->isSuccessful()) {
            return $process->getOutput();
        }

        $process->clearOutput();

        throw new ProcessFailedException($process);
    }
}
