<?php

namespace SamuelMwangiW\Vite;

use SamuelMwangiW\Vite\Commands\ViteCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
