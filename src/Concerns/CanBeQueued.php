<?php

namespace pxlrbt\LaravelPdfable\Concerns;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

trait CanBeQueued
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Entrypoint for jobs
     */
    public function handle(): void
    {
        $this->save();
    }
}
