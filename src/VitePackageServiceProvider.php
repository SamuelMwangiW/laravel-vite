<?php

namespace SamuelMwangiW\Vite;

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
}
