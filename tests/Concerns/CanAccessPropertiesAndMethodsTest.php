<?php

use pxlrbt\LaravelPdfable\Pdfable;

beforeEach(function () {
    // Clear static caches between tests
    $reflection = new ReflectionClass(Pdfable::class);

    $propertyCache = $reflection->getProperty('propertyCache');
    $propertyCache->setValue(null, []);

    $methodCache = $reflection->getProperty('methodCache');
    $methodCache->setValue(null, []);
});

it('exposes public properties via data()', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';

        public string $title = 'My Title';
    };

    $data = $pdf->data();

    expect($data)->toHaveKey('title', 'My Title');
});

it('excludes static properties from data()', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';

        public static string $staticProp = 'hidden';
    };

    $data = $pdf->data();

    expect($data)->not->toHaveKey('staticProp');
});

it('exposes public methods as invokable variables', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';

        public function greeting(): string
        {
            return 'Hello World';
        }
    };

    $data = $pdf->data();

    expect($data)->toHaveKey('greeting')
        ->and((string) $data['greeting'])->toBe('Hello World');
});

it('exposes methods with parameters as closures', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';

        public function greet(string $name): string
        {
            return "Hello {$name}";
        }
    };

    $data = $pdf->data();

    expect($data)->toHaveKey('greet')
        ->and($data['greet'])->toBeInstanceOf(Closure::class)
        ->and($data['greet']('World'))->toBe('Hello World');
});

it('ignores magic methods', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';
    };

    $data = $pdf->data();

    expect($data)->not->toHaveKey('__construct');
});

it('ignores methods listed in ignoredMethods', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';
    };

    $data = $pdf->data();

    expect($data)->not->toHaveKey('data')
        ->and($data)->not->toHaveKey('render')
        ->and($data)->not->toHaveKey('shouldRender');
});

it('respects except property', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';

        protected $except = ['customMethod'];

        public function customMethod(): string
        {
            return 'hidden';
        }
    };

    $data = $pdf->data();

    expect($data)->not->toHaveKey('customMethod');
});

it('includes attributes in data', function () {
    $pdf = new class extends Pdfable
    {
        public string $view = 'test-view';
    };

    $data = $pdf->data();

    expect($data)->toHaveKey('attributes');
});
