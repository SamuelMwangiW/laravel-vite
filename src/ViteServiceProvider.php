<?php

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\Blade;
use SamuelMwangiW\Vite\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ViteServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'laravel-vite')
            ->hasConfigFile()
            ->hasCommand(commandClassName: InstallCommand::class);
    }
}
