<?php

return [
    /**
     * The Vite URL accessible from the web server to vite to fetch modules from
     * This is necessary in local environment to determine the script to load
     * In docker, this would be "http://host.docker.internal:3000"
     */

    'vite_host' => env('VITE_URL','http://localhost:3000'),
];
