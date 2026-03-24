<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::deleteDirectory(app_path('Pdfs'));
    File::deleteDirectory(resource_path('views/pdfs'));
});

afterEach(function () {
    File::deleteDirectory(app_path('Pdfs'));
    File::deleteDirectory(resource_path('views/pdfs'));
});

it('creates a pdfable class and view', function () {
    $this->artisan('make:pdf', ['name' => 'Invoice'])
        ->assertSuccessful();

    expect(File::exists(app_path('Pdfs/Invoice.php')))->toBeTrue()
        ->and(File::exists(resource_path('views/pdfs/invoice.blade.php')))->toBeTrue();
});

it('generates correct class content', function () {
    $this->artisan('make:pdf', ['name' => 'Invoice']);

    $content = File::get(app_path('Pdfs/Invoice.php'));

    expect($content)->toContain('namespace App\Pdfs')
        ->and($content)->toContain('class Invoice extends Pdfable')
        ->and($content)->toContain("public string \$view = 'invoice'");
});

it('generates correct view content', function () {
    $this->artisan('make:pdf', ['name' => 'Invoice']);

    $content = File::get(resource_path('views/pdfs/invoice.blade.php'));

    expect($content)->toContain("@extends('laravel-pdfable::base')")
        ->and($content)->toContain("@section('content')");
});

it('converts name to studly case for class', function () {
    $this->artisan('make:pdf', ['name' => 'monthly-report']);

    expect(File::exists(app_path('Pdfs/MonthlyReport.php')))->toBeTrue();

    $content = File::get(app_path('Pdfs/MonthlyReport.php'));

    expect($content)->toContain('class MonthlyReport extends Pdfable');
});

it('rejects invalid class names', function () {
    $this->artisan('make:pdf', ['name' => '123invalid'])
        ->assertSuccessful();

    expect(File::exists(app_path('Pdfs/123invalid.php')))->toBeFalse();
});

it('rejects reserved class names', function () {
    $this->artisan('make:pdf', ['name' => 'class'])
        ->assertSuccessful();

    expect(File::exists(app_path('Pdfs/Class.php')))->toBeFalse();
});

it('does not overwrite existing files without force', function () {
    $this->artisan('make:pdf', ['name' => 'Invoice']);

    File::put(app_path('Pdfs/Invoice.php'), 'original content');

    $this->artisan('make:pdf', ['name' => 'Invoice']);

    expect(File::get(app_path('Pdfs/Invoice.php')))->toBe('original content');
});

it('overwrites existing files with force flag', function () {
    $this->artisan('make:pdf', ['name' => 'Invoice']);

    File::put(app_path('Pdfs/Invoice.php'), 'original content');

    $this->artisan('make:pdf', ['name' => 'Invoice', '--force' => true]);

    expect(File::get(app_path('Pdfs/Invoice.php')))->not->toBe('original content')
        ->and(File::get(app_path('Pdfs/Invoice.php')))->toContain('class Invoice extends Pdfable');
});
