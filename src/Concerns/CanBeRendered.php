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
        return response()->streamDownload(function () {
            echo $this->driver()->getData($this);
        },
            $filename ?? $this->displayFilename(),
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
