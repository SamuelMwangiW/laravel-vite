
# Laravel Vite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelmwangiw/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/laravel-vite)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/laravel-vite/run-tests?label=tests)](https://github.com/samuelmwangiw/laravel-vite/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/laravel-vite/Check%20&%20fix%20styling?label=code%20style)](https://github.com/samuelmwangiw/laravel-vite/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelmwangiw/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/laravel-vite)

A tiny package that adds @vite_assets blade directive and loads Vite assets.

This improves the developer experience by using the blazing fast Vite HMR instead of webpack compilation offered in Laravel Mix

## Installation

You can install the package via composer:

```bash
composer require samuelmwangiw/laravel-vite
```
## New Project

The easiest way to get started is to create a new Laravel project.

 - Create a new project and run the following command: `laravel new awesome-project`
 - Setup [Jetstream](https://jetstream.laravel.com/2.x/installation.html#or-install-jetstream-with-inertia) with Inertia 
 ```shell
   cd awesome-project
   composer require laravel/jetstream
   php artisan jetstream:install inertia
   ```
 - or [Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze) with Vue
```shell
   cd awesome-project
   composer require laravel/breeze --dev
   php artisan breeze:install vue
   ```
 - Run `vite:install` command to setup vite
```shell
php artisan vite:install
```
 - Run `npm install` to install the dependencies and `npm run dev` to start the development server
 - Build your amazing project

### Existing Project
First remove `laravel-mix` and `webpack` related packages from your project.

```bash
npm remove laravel-mix postcss-import vue-loader
npm i -D vite @vitejs/plugin-vue
```
Setup Tailwindcss as necessary:
```bash
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
```
To use Tailwindcss with vite, you also need to ensure that you publish the config files to your project by running `npx tailwind init -p`. 

See below sample config files:

```js
//tailwind.config.js

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
```

```js
//postcss.config.js

module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
}
```

```js
// vite.config.js

import vue from '@vitejs/plugin-vue';
import path from 'path'

export default ({ command }) => ({
    base: command === 'serve' ? '' : '/build/',
    publicDir: false,
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
    resolve:{
        alias:{
            '@' : path.resolve(__dirname, 'resources/js')
        },
    },
    plugins: [vue()],
});
```

### File Extensions
Current versions of Breeze and Jetstream have added .vue extensions to imports therefore you can skip this section if you are adding the package to a new application.

You need to ensure you application code includes .vue file extension for all imports.

```diff
- import MyComponent from '@/Components/MyComponent';
+ import MyComponent from '@/Components/MyComponent.vue';
```

### require() to import

To use vite, you need to switch require() statements to import.

```diff
 // resources/js/app.js
 
-require('./bootstrap');
+import './bootstrap';
+import '../css/app.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
-    resolve: (name) => require(`./Pages/${name}.vue`),
+    resolve: async (name) => {
+        const pages = import.meta.glob('./Pages/**/*.vue');
+
+        return (await pages[`./Pages/${name}.vue`]()).default;
+    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
```

```diff
 // resources/js/bootstrap.js
 
- window._ = require('lodash');
+ import _ from 'lodash';
+ import axios from 'axios';
+ // import Pusher from 'pusher-js
+ 
+ window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

- window.axios = require('axios');
+ window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

- // window.Pusher = require('pusher-js');
+ // window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
```

Finally, update the scripts section in your `package.json` by replacing mix with vite:

```diff
    "scripts": {
-        "dev": "npm run development",
-        "development": "mix",
-        "watch": "mix watch",
-        "watch-poll": "mix watch -- --watch-options-poll=1000",
-        "hot": "mix watch --hot",
-        "prod": "npm run production",
-        "production": "mix --production"
+        "dev": "vite",
+        "sail": "vite --host",
+        "prod": "npm run production",
+        "production": "vite build"
    },
```

Note that I have `npm run vite` because vite by default is only available on localhost hence not reachable from a docker container but you skip this option if does not apply to you.

## Usage
Add `@vite_assets` to your blade template and delete the following:

```diff
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

-        <!-- Styles -->
-        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
-       <script src="{{ mix('js/app.js') }}" defer></script>
+       @vite_assets
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

-        <!-- With vite, browser-sync is not necessary -->
-        @env ('local')
-            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
-        @endenv
    </body>
</html>
```
The final output will look like this:

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        @vite_assets
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Samuel Mwangi](https://github.com/SamuelMwangiW)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
