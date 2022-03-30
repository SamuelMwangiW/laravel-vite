<?php

namespace SamuelMwangiW\Vite\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    public $signature = 'vite:install';

    public $description = 'Sets up vite on a Breeze / Jetstream Inertia Install';

    public function handle(): int
    {
        if (
            ! $this->confirm(question: "This action will overwrite some files and cannot be undone. Are you sure?")
        ) {
            $this->comment(string: 'Phew... That was close!');

            return parent::SUCCESS;
        }

        $this->copyStubs();

        $this->info(string: 'Setup Done. ');
        $this->comment(string: 'Run `npm install && npm run dev`');

        return parent::SUCCESS;
    }

    /**
     * @return void
     */
    public function copyStubs(): void
    {
        (new Filesystem())->ensureDirectoryExists(resource_path('js'));

        copy(__DIR__ . '/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));

        if (! file_exists(base_path('tailwind.config.js'))) {
            copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        }

        copy(from: __DIR__ . '/../../stubs/entry.app.js', to: resource_path('js/app.js'));
        copy(__DIR__ . '/../../stubs/entry.bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__ . '/../../stubs/package.json', base_path('package.json'));
    }

    /**
     * Replace a given string within a given file.
     *
     * @param string $search
     * @param string $replace
     * @param string $path
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
