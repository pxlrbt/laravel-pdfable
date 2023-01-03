<?php

namespace pxlrbt\LaravelPdfable\Concerns;

use Illuminate\Support\Facades\Storage;

trait CanBeStored
{
    protected ?string $disk = null;

    public function filename(): string
    {
        return 'default.pdf';
    }

    public function disk(?string $disk = null): static
    {
        $this->disk = $disk;

        return $this;
    }

    protected function getDisk(): string
    {
        return $this->disk ?? config('filesystems.default');
    }

    public function save(?string $filename = null): static
    {
        Storage::disk($this->getDisk())->put(
            $filename ?? $this->filename(),
            $this->driver()->getData($this),
        );

        return $this;
    }
}
