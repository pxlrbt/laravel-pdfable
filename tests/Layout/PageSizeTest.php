<?php

use pxlrbt\LaravelPdfable\Layout\PageSize;

it('returns correct dimensions for A4', function () {
    expect(PageSize::A4->size())->toBe([210, 297]);
});

it('returns correct dimensions for A3', function () {
    expect(PageSize::A3->size())->toBe([297, 420]);
});

it('returns correct dimensions for A5', function () {
    expect(PageSize::A5->size())->toBe([148, 210]);
});

it('returns correct dimensions for Letter', function () {
    expect(PageSize::Letter->size())->toBe([216, 279]);
});

it('returns correct dimensions for Legal', function () {
    expect(PageSize::Legal->size())->toBe([216, 356]);
});

it('returns correct dimensions for Tabloid', function () {
    expect(PageSize::Tabloid->size())->toBe([279, 432]);
});
