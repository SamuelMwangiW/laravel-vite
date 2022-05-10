<?php

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\Blade;
use SamuelMwangiW\Vite\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VitePackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'laravel-vite')
            ->hasConfigFile()
            ->hasCommand(commandClassName: InstallCommand::class);
    }

    public function bootingPackage()
    {
        Blade::directive('vite_assets', fn () => $this->app->make(Vite::class)->assets());
    }
}
