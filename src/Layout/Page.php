<?php

namespace pxlrbt\LaravelPdfable\Layout;

class Page
{
    protected array $size;

    protected array $margins;

    protected PageOrientation $orientation;

    public static function make()
    {
        return (new static)
            ->size(config('pdfable.layout.defaults.page-size'))
            ->orientation(config('pdfable.layout.defaults.orientation'))
            ->margins(config('pdfable.layout.defaults.margins'));
    }

    public function margins(array|string|null $margins = null)
    {
        if (is_array($margins)) {
            $this->margins = $margins;

            return $this;
        }

        $this->margins = config('pdfable.layout.margins')[$margins];

        return $this;
    }

    public function size(PageSize|array $size): static
    {
        $this->size = is_array($size) ? $size : $size->size();

        return $this;
    }

    public function orientation(PageOrientation $orientation): static
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function portrait(): static
    {
        $this->orientation = PageOrientation::Portrait;

        return $this;
    }

    public function landscape(): static
    {
        $this->orientation = PageOrientation::Landscape;

        return $this;
    }

    public function getHeight()
    {
        return $this->orientation === PageOrientation::Portrait
            ? $this->size[1]
            : $this->size[0];
    }

    public function getWidth()
    {
        return $this->orientation === PageOrientation::Portrait
            ? $this->size[0]
            : $this->size[1];
    }

    public function getMargins(): array
    {
        return $this->margins;
    }

    public function getMarginTop()
    {
        return $this->margins[0];
    }

    public function getMarginRight()
    {
        return $this->margins[1];
    }

    public function getMarginBottom()
    {
        return $this->margins[2];
    }

    public function getMarginLeft()
    {
        return $this->margins[3];
    }
}
