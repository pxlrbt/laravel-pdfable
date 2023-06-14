<?php

namespace pxlrbt\LaravelPdfable\Layout;

enum PageSize
{
    case Letter;
    case Legal;
    case Tabloid;

    case A3;
    case A4;
    case A5;

    public function size(): array
    {
        return match ($this) {
            self::Letter => [216, 279],
            self::Legal => [216, 356],
            self::Tabloid => [279, 432],

            self::A3 => [297, 420],
            self::A4 => [210, 297],
            self::A5 => [148, 210],
        };
    }
}
