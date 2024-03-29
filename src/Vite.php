<?php

declare(strict_types=1);

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Vite
{
    public function assets(): HtmlString
    {
        if ($this->devServerIsRunning()) {
            return $this->devScripts();
        }

        return $this->productionScripts();
    }

    public function devServerIsRunning(): bool
    {
        if (app()->environment('local')) {
            try {
                return Http::timeout(seconds: 1)
                    ->get(url: $this->getDevHost())
                    ->successful();
            } catch (\Exception $exception) {
                return Str::of(
                    $exception->getMessage()
                )->contains('cURL error 52: Empty reply from server');
            }
        }

        return false;
    }

    public function getDevHost(): string
    {
        return strval(config('vite.vite_host'));
    }

    protected function devScripts(): HtmlString
    {
        return new HtmlString(
            html: '<script type="module" src="http://localhost:' . $this->port() . '/@vite/client"></script>'
            . '<script type="module" src="http://localhost:' . $this->port() . '/resources/js/app.js"></script>'
        );
    }

    protected function productionScripts(): HtmlString
    {
        $css = $this->assetPath(asset: 'app.css');
        $js = $this->assetPath(asset: 'app.js');

        return new HtmlString(
            html: "<link rel='stylesheet' href='{$css}'><script type='module' src='{$js}'></script>"
        );
    }

    protected function assetPath(string $asset): string
    {
        $glob = $this->glob(asset: $asset);

        if ($glob === false || sizeof(value: $glob) !== 1) {
            return '';
        }

        return str_replace(
            search: public_path(),
            replace: '',
            subject: $glob[0]
        );
    }

    protected function glob(string $asset): array|false
    {
        $asset = str_replace(search: '.', replace: '.*.', subject: $asset);

        return File::glob(
            pattern: public_path("build/assets/{$asset}")
        );
    }

    private function port(): int
    {
        return intval(config('vite.port'));
    }
}
