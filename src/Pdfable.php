<?php

namespace pxlrbt\LaravelPdfable;

use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use pxlrbt\LaravelPdfable\Layout\Page;

abstract class Pdfable implements Attachable, Renderable, ShouldQueue
{
    use Concerns\CanAccessPropertiesAndMethods;
    use Concerns\CanBeAttached;
    use Concerns\CanBeQueued;
    use Concerns\CanBeRendered;
    use Concerns\CanBeStored;

    public string $view;

    public bool $preview = false;

    public function driver()
    {
        $driver = config('pdfable.default');
        $drivers = config('pdfable.drivers');

        return app($drivers[$driver]);
    }

    public function getView(): View
    {
        return view($this->view, $this->data());
    }

    public function page(): Page
    {
        return Page::make();
    }
}
