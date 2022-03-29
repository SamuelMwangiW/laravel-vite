<?php

namespace SamuelMwangiW\Vite;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SamuelMwangiW\Vite\Commands\ViteCommand;

class ViteServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-vite')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-vite_table')
            ->hasCommand(ViteCommand::class);
    }
}
