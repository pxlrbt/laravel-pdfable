<?php

namespace pxlrbt\LaravelPdfable\Concerns;

trait CanBeRendered
{
    public function displayFilename(): string
    {
        return basename($this->filename());
    }

    public function stream()
    {
        return response()->stream(function () {
            echo $this->driver()->getData($this);
        },
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function download(?string $filename = null)
    {
        $filename = $filename ?? $this->displayFilename();

        // Remove all characters that are not the separator, letters, numbers, or whitespace
        $sanitizedFilename = preg_replace('![^'.preg_quote('-').'\pL\pN\s]+!u', '', $filename);

        return response()->streamDownload(function () {
            echo $this->driver()->getData($this);
        },
            $sanitizedFilename,
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Entrypoint for responses
     */
    public function render()
    {
        $this->preview = true;

        return $this->getView();
    }
}
