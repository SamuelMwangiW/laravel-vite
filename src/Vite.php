<?php

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

class Vite
{
    public static function assets(): HtmlString
    {
        if (self::devServerIsRunning()) {
            return self::devScripts();
        }

        return self::productionScripts();
    }

    public static function devServerIsRunning(): bool
    {
        if (app()->environment('local')) {
            try {
                Http::timeout(seconds: 1)
                    ->get(url: self::getDevHost());

                return true;
            } catch (\Exception) {
                return false;
            }
        }

        return false;
    }

    public static function getDevHost(): string
    {
        return config('vite.vite_host');
    }

    public static function devScripts(): HtmlString
    {
        return new HtmlString(
            html: <<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
        HTML
        );
    }

    public static function productionScripts(): HtmlString
    {
        $css = self::assetPath(asset: 'app.css');
        $js = self::assetPath(asset: 'app.js');

        return new HtmlString(
            html:"<link rel='stylesheet' href='{$css}'><script type='module' src='{$js}'></script>"
        );
    }

    public static function assetPath(string $asset): string
    {
        $glob = self::glob(asset: $asset);

        if ($glob === false || sizeof(value: $glob) !== 1) {
            return '';
        }

        return str_replace(
            search: public_path(),
            replace: '',
            subject: $glob[0]
        );
    }

    protected static function glob(string $asset): array|false
    {
        $asset = str_replace(search: '.', replace: '.*.', subject: $asset);

        return glob(
            pattern: public_path("build/assets/{$asset}")
        );
    }
}
