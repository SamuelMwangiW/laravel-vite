<?php

namespace Samuelmwangiw\LaravelVite;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('vite_assets',function (){
            return Vite::assets();
        });
    }
}