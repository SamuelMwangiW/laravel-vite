<?php

namespace SamuelMwangiW\Vite\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    public $signature = 'vite:install';

    public $description = 'Sets up vite on a Breeze / Jetstream Inertia Install';

    public function handle(): int
    {
        if (
            !$this->confirm(question: "This action will overwrite some files and cannot be undone. Are you sure?")
        ) {
            $this->comment(string: 'Phew... That was close!');

            return parent::SUCCESS;
        }

        $this->copyStubs();
        $this->flushNodeModules();
        $this->flushWebpackFiles();

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
        (new Filesystem())->ensureDirectoryExists(resource_path('views'));

        copy(__DIR__ . '/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));

        if (!file_exists(base_path('tailwind.config.js'))) {
            copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        }

        copy(from: __DIR__ . '/../../stubs/entry.app.js', to: resource_path('js/app.js'));
        copy(__DIR__ . '/../../stubs/entry.bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__ . '/../../stubs/app.blade.php', resource_path('views/app.blade.php'));
        copy(__DIR__ . '/../../stubs/package.json', base_path('package.json'));
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules(): void
    {
        tap(new Filesystem(), function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    protected function flushWebpackFiles(): void
    {
        File::delete([
            base_path('webpack.mix.js'),
            base_path('webpack.config.js'),
            public_path('mix-manifest.json'),
        ]);
    }
}
