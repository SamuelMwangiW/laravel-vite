<?php

namespace Samuelmwangiw\LaravelVite;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use JetBrains\PhpStorm\Pure;

class Vite
{
    static function assets(): HtmlString
    {
        if (self::devServerIsRunning()) {
            return self::devScripts();
        }

        return self::productionScripts();
    }

    static function devServerIsRunning(): bool
    {
        if (App::environment(environments: 'local')) {
            try {
                Http::get(url: self::getDevHost());
                return true;
            } catch (\Exception) {
                return false;
            }
        }
        return false;
    }

    static function getDevHost(): string
    {
        return env(key: 'LARAVEL_SAIL')
            ? "http://host.docker.internal:3000"
            : "http://localhost:3000";
    }

    #[Pure] static function devScripts(): HtmlString
    {
        return new HtmlString(html: <<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
        HTML
        );
    }

    static function productionScripts(): HtmlString
    {
        $css = self::assetPath(asset: 'app.css');
        $js = self::assetPath(asset: 'app.js');

        return new HtmlString(
            html:"<link rel='stylesheet' href='{$css}'><script type='module' src='{$js}'></script>"
        );
    }

    static function assetPath(string $asset): string
    {
        $glob = self::glob(asset: $asset);

        if (sizeof(value: $glob) !== 1) {
            return '';
        }

        return str_replace(
            search: self::public_path(),
            replace: '',
            subject: $glob[0]
        );
    }

    protected static function glob(string $asset): array|false
    {
        $asset = str_replace(search: '.', replace: '.*.',subject: $asset);
        return glob(
            pattern: self::public_path(path: "build/assets/{$asset}")
        );
    }

    protected static function public_path(string $path = ''): string
    {
        return App::make('path.public').($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path);;
    }

}