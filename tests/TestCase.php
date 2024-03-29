<?php

declare(strict_types=1);

namespace SamuelMwangiW\Vite\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SamuelMwangiW\Vite\ViteServiceProvider;

class TestCase extends Orchestra
{
    private string $appConfig = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->appConfig = file_get_contents(config_path('app.php'));
    }

    protected function tearDown(): void
    {
        file_put_contents(
            config_path('app.php'),
            $this->appConfig,
        );

        parent::tearDown();
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
        config()->set('vite.port', 3000);
    }
}
