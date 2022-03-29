<?php

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ViteServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-vite')
            ->hasConfigFile();
    }

    public function bootingPackage()
    {
        Blade::directive('vite_assets', function () {
            return Vite::assets();
        });
    }
}
