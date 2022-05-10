<?php

namespace SamuelMwangiW\Vite\Tests;

use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase as Orchestra;
use SamuelMwangiW\Vite\VitePackageServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    protected function getPackageProviders($app)
    {
        return [
            VitePackageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('vite.vite_host', 'https://vite.example.com:3000/');
    }
}
