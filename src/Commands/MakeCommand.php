<?php

namespace pxlrbt\LaravelPdfable\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCommand extends Command
{
    protected $signature = 'make:pdf {name} {--force}';

    protected $description = 'Create a new Pdfable class and view';

    public function handle()
    {
        $namespace = 'App\\Pdfs';
        $name = $this->argument('name');
        $class = Str::studly($name);
        $view = Str::lower($name);

        if (! $this->isClassNameValid($class)) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is invalid:</> {$class}");

            return;
        }

        if ($this->isReservedClassName($class)) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is reserved:</> {$class}");

            return;
        }

        $force = $this->option('force');

        $data = [
            'namespace' => $namespace,
            'class' => $class,
            'view' => $view,
        ];

        $class = $this->createClass($class, $data, $force);
        $view = $this->createView($view, $force);

        if ($class || $view) {
            $this->line("<options=bold,reverse;fg=green> COMPONENT CREATED </> 🤙\n");
            $class && $this->line("<options=bold;fg=green>CLASS:</> $class");
            $view && $this->line("<options=bold;fg=green>VIEW:</>  $view");
        }
    }

    protected function createClass($name, $data, $force = false)
    {
        $path = app_path("Pdfs/{$name}.php");

        if (File::exists($path) && ! $force) {
            $this->line("<fg=red;options=bold>Class already exists:</> {$path}");

            return false;
        }

        $this->copyStubToApp('Pdfable', $path, $data);

        return $path;
    }

    protected function createView($name, $force = false)
    {
        $path = resource_path("views/pdfs/{$name}.blade.php");

        if (File::exists($path) && ! $force) {
            $this->line("<fg=red;options=bold>View already exists:</> {$path}");

            return false;
        }

        $this->copyStubToApp('view', $path);

        return $path;
    }

    public function isClassNameValid($name)
    {
        return preg_match("/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/", $name);
    }

    public function isReservedClassName($name)
    {
        return array_search(strtolower($name), $this->getReservedName()) !== false;
    }

    protected function copyStubToApp(string $stub, string $targetPath, array $replacements = []): void
    {
        $filesystem = app(Filesystem::class);

        if (! File::exists($stubPath = base_path("stubs/laravel-pdfable/{$stub}.stub"))) {
            $stubPath = realpath(__DIR__."/../../stubs/{$stub}.stub");
        }

        $stub = Str::of($filesystem->get($stubPath));

        foreach ($replacements as $key => $replacement) {
            $stub = $stub->replace("{{ {$key} }}", $replacement);
        }

        $stub = (string) $stub;

        File::makeDirectory(dirname($targetPath), force: true);

        File::put($targetPath, $stub);
    }

    private function getReservedName()
    {
        return [
            'parent',
            'component',
            'interface',
            '__halt_compiler',
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'callable',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'die',
            'do',
            'echo',
            'else',
            'elseif',
            'empty',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'eval',
            'exit',
            'extends',
            'final',
            'finally',
            'fn',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'include',
            'include_once',
            'instanceof',
            'insteadof',
            'interface',
            'isset',
            'list',
            'namespace',
            'new',
            'or',
            'print',
            'private',
            'protected',
            'public',
            'require',
            'require_once',
            'return',
            'static',
            'switch',
            'throw',
            'trait',
            'try',
            'unset',
            'use',
            'var',
            'while',
            'xor',
            'yield',
        ];
    }
}
