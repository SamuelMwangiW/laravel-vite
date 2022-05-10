<?php

namespace App\Providers;

use App\Utils\Vite;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('vite_assets', fn () => $this->app->make(Vite::class)->assets());
    }
}
