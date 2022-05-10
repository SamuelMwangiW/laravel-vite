<?php

namespace SamuelMwangiW\Vite\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        $this->installServiceProviderAfter('RouteServiceProvider', 'ViteServiceProvider');
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
        (new Filesystem())->ensureDirectoryExists(app_path('Utils'));

        copy(__DIR__ . '/../../stubs/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__ . '/../../stubs/postcss.config.js', base_path('postcss.config.js'));

        if (! file_exists(base_path('tailwind.config.js'))) {
            copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        }
        if (! file_exists(app_path('Utils/Vite.php'))) {
            (new Filesystem)->copy(__DIR__ . '/../Vite.php', app_path('Utils/Vite.php'));

            $this->replaceInFile(
                search: 'namespace SamuelMwangiW\Vite;',
                replace: 'namespace App\Utils\Vite;',
                path: app_path('Utils/Vite.php')
            );
        }

        (new Filesystem)->copy( __DIR__ . '/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        (new Filesystem)->copy(__DIR__ . '/../../stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        (new Filesystem)->copy(__DIR__ . '/../../stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));
        (new Filesystem)->copy(__DIR__ . '/../../stubs/package.json', base_path('package.json'));
        (new Filesystem)->copy(__DIR__ . '/../../stubs/app/Providers/ViteServiceProvider.php', app_path('Providers/ViteServiceProvider.php'));
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

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }
}
