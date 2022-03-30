<?php

namespace SamuelMwangiW\Vite\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SamuelMwangiW\Vite\ViteServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ViteServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('vite.vite_host', 'https://vite.example.com:3000/');
    }
}
