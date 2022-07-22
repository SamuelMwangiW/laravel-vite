<?php

declare(strict_types=1);

return [
    /**
     * The Vite URL accessible from the web server to vite to fetch modules from
     * This is necessary in local environment to determine the script to load
     * In docker, it would be "http://host.docker.internal:3000"
     */

    'port' => $vite_port = env('VITE_PORT', 5173),
    'vite_host' => env(
        key: 'VITE_URL',
        default: env(key: 'LARAVEL_SAIL', default: false)
            ? 'http://host.docker.internal:' . $vite_port
            : 'http://localhost:' . $vite_port
    ),
];
