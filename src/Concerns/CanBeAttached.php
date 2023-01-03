<?php

namespace pxlrbt\LaravelPdfable\Concerns;

use Illuminate\Mail\Attachment;

trait CanBeAttached
{
    /**
     * Entrypoint for Mailables
     */
    public function toMailAttachment(): Attachment
    {
        return Attachment::fromData(
            fn () => $this->driver()->getData($this),
            $this->displayFilename() ?? 'attachment.pdf'
        );
    }
}
