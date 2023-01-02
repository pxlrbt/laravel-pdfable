<?php

namespace pxlrbt\LaravelPdfable;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Mail\Attachment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\View\Component;
use pxlrbt\LaravelPdfable\Layout\Page;
use Storage;

abstract class Pdfable extends Component implements Renderable, ShouldQueue, Attachable
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $view;

    public bool $preview = false;

    abstract public function outputFile(): string;

    public function filename(): string
    {
        return basename($this->outputFile());
    }

    public function page(): Page
    {
        return Page::make();
    }

    public function getView(): View
    {
        return view($this->view, $this->data());
    }

    public function driver()
    {
        $driver = config('pdfable.default');
        $drivers = config('pdfable.drivers');

        return app($drivers[$driver]);
    }

    public function save(?string $filename = null): static
    {
        Storage::put(
            $filename ?? $this->outputFile(),
            $this->driver()->getData($this),
        );

        return $this;
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
            $filename ?? $this->filename(),
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Entrypoint for Mailables
     */
    public function toMailAttachment(): Attachment
    {
        return Attachment::fromData(
            fn () => $this->driver()->getData($this),
            $this->filename() ?? 'attachment.pdf'
        );
    }

    /**
     * Entrypoint for jobs
     */
    public function handle(): void
    {
        $this->save();
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
