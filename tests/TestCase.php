<?php

namespace SamuelMwangiW\Vite\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SamuelMwangiW\Vite\BaseViteServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            BaseViteServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('vite.vite_host', 'https://vite.example.com:3000/');
    }
}
