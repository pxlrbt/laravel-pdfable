<?php

use pxlrbt\LaravelPdfable\Layout\Page;
use pxlrbt\LaravelPdfable\Layout\PageOrientation;
use pxlrbt\LaravelPdfable\Layout\PageSize;

it('creates page with default config values', function () {
    $page = Page::make();

    expect($page->getWidth())->toBe(210)
        ->and($page->getHeight())->toBe(297)
        ->and($page->getMargins())->toBe([25.4, 19.05, 25.4, 19.05]);
});

it('sets size from PageSize enum', function () {
    $page = Page::make()->size(PageSize::A3);

    expect($page->getWidth())->toBe(297)
        ->and($page->getHeight())->toBe(420);
});

it('sets size from custom array', function () {
    $page = Page::make()->size([100, 200]);

    expect($page->getWidth())->toBe(100)
        ->and($page->getHeight())->toBe(200);
});

it('sets orientation to landscape', function () {
    $page = Page::make()->landscape();

    expect($page->getWidth())->toBe(297)
        ->and($page->getHeight())->toBe(210);
});

it('sets orientation to portrait', function () {
    $page = Page::make()->landscape()->portrait();

    expect($page->getWidth())->toBe(210)
        ->and($page->getHeight())->toBe(297);
});

it('sets orientation via enum', function () {
    $page = Page::make()->orientation(PageOrientation::Landscape);

    expect($page->getWidth())->toBe(297)
        ->and($page->getHeight())->toBe(210);
});

it('swaps width and height in landscape mode', function () {
    $page = Page::make()->size(PageSize::A5)->landscape();

    expect($page->getWidth())->toBe(210)
        ->and($page->getHeight())->toBe(148);
});

it('sets margins from named preset string', function () {
    $page = Page::make()->margins('narrow');

    expect($page->getMargins())->toBe([12.7, 12.7, 12.7, 12.7]);
});

it('sets margins from custom array', function () {
    $page = Page::make()->margins([10, 20, 30, 40]);

    expect($page->getMargins())->toBe([10, 20, 30, 40]);
});

it('returns individual margins', function () {
    $page = Page::make()->margins([10, 20, 30, 40]);

    expect($page->getMarginTop())->toBe(10)
        ->and($page->getMarginRight())->toBe(20)
        ->and($page->getMarginBottom())->toBe(30)
        ->and($page->getMarginLeft())->toBe(40);
});

it('supports none margins preset', function () {
    $page = Page::make()->margins('none');

    expect($page->getMargins())->toBe([0, 0, 0, 0]);
});

it('supports wide margins preset', function () {
    $page = Page::make()->margins('wide');

    expect($page->getMargins())->toBe([25.4, 50.8, 25.4, 50.8]);
});

it('returns fluent interface from all setters', function () {
    $page = Page::make();

    expect($page->size(PageSize::A4))->toBeInstanceOf(Page::class)
        ->and($page->orientation(PageOrientation::Portrait))->toBeInstanceOf(Page::class)
        ->and($page->portrait())->toBeInstanceOf(Page::class)
        ->and($page->landscape())->toBeInstanceOf(Page::class)
        ->and($page->margins('narrow'))->toBeInstanceOf(Page::class);
});
