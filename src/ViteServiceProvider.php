<?php

namespace Samuelmwangiw\LaravelVite;

use Illuminate\Support\Facades\Blade;

class ViteServiceProvider
{
    public function boot()
    {
        Blade::directive('vite_assets',function (){
            return Vite::assets();
        });
    }
}