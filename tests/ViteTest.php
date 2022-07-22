<?php

declare(strict_types=1);

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use SamuelMwangiW\Vite\Tests\DummyRequest;
use SamuelMwangiW\Vite\Vite;

it('can resolve Vite from the container')
    ->expect(app()->make(Vite::class))
    ->toBeInstanceOf(Vite::class)
    ->not->toThrow(BindingResolutionException::class);

it('can get the vite host')
    ->expect(app()->make(Vite::class))
    ->getDevHost()->toBeString()->toBe('https://vite.example.com:3000/');

it('only checks if dev server is running in a local environment', function () {
    Http::fake();
    app()->detectEnvironment(fn () => 'production');

    expect(app()->make(Vite::class))
        ->devServerIsRunning()
        ->toBeFalse();

    app()->detectEnvironment(fn () => 'testing');

    expect(app()->make(Vite::class))
        ->devServerIsRunning()
        ->toBeFalse();

    Http::assertNotSent(function (Request $request) {
        return $request->url() === 'https://vite.example.com:3000/';
    });

    app()->detectEnvironment(fn () => 'local');

    expect(app()->make(Vite::class))
        ->devServerIsRunning()
        ->toBeTrue();

    Http::assertSent(function (Request $request) {
        return $request->url() === 'https://vite.example.com:3000/';
    });
});

it('returns false when the dev server is unreachable', function () {
    Http::fake(function ($request) {
        throw new ConnectException(
            'Time Out',
            new DummyRequest()
        );
    });

    app()->detectEnvironment(fn () => 'local');

    expect(app()->make(Vite::class))
        ->devServerIsRunning()
        ->toBeFalse();
});

it('returns dev scripts when the dev server is running', function () {
    app()->detectEnvironment(fn () => 'local');
    Http::fake();

    $devScript = new HtmlString(
        '<script type="module" src="http://localhost:3000/@vite/client"></script><script type="module" src="http://localhost:3000/resources/js/app.js"></script>'
    );

    expect(app()->make(Vite::class))
        ->assets()
        ->toHtml()->toBe($devScript->toHtml());
});

it('returns prod scripts when the dev server is unreachable', function () {
    app()->detectEnvironment(fn () => 'local');

    Http::fake(function ($request) {
        throw new ConnectException(
            'Time Out',
            new DummyRequest()
        );
    });

    $response = new HtmlString('<link rel=\'stylesheet\' href=\'\'><script type=\'module\' src=\'\'></script>');

    expect(app()->make(Vite::class))
        ->assets()
        ->toHtml()->toBe($response->toHtml());
});
