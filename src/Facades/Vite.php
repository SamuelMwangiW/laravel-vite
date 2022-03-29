<?php

namespace SamuelMwangiW\Vite\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SamuelMwangiW\Vite\Vite
 */
class Vite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-vite';
    }
}
