<?php

namespace Samuelmwangiw\LaravelVite;

use Illuminate\Support\Facades\Facade;

class ViteFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return Vite::class;
    }
}