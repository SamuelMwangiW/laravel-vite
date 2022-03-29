<?php

namespace SamuelMwangiW\Vite;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

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
                Http::timeout(seconds: 1)
                    ->get(url: $this->getDevHost());

                return true;
            } catch (\Exception) {
                return false;
            }
        }

        return false;
    }

    public function getDevHost(): string
    {
        return config('vite.vite_host');
    }

    public function devScripts(): HtmlString
    {
        return new HtmlString(
            html: <<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
        HTML
        );
    }

    public function productionScripts(): HtmlString
    {
        $css = $this->assetPath(asset: 'app.css');
        $js = $this->assetPath(asset: 'app.js');

        return new HtmlString(
            html:"<link rel='stylesheet' href='{$css}'><script type='module' src='{$js}'></script>"
        );
    }

    public function assetPath(string $asset): string
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

        return glob(
            pattern: public_path("build/assets/{$asset}")
        );
    }
}
