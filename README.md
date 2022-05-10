
# Laravel Vite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelmwangiw/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/laravel-vite)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/laravel-vite/run-tests?label=tests)](https://github.com/samuelmwangiw/laravel-vite/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/laravel-vite/Check%20&%20fix%20styling?label=code%20style)](https://github.com/samuelmwangiw/laravel-vite/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelmwangiw/laravel-vite.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/laravel-vite)

A tiny package that adds @vite_assets blade directive and loads Vite assets.

This improves the developer experience by using the blazing fast Vite HMR instead of webpack compilation offered in Laravel Mix

## Installation

The easiest way to get started is to create a new Laravel project.

 - Create a new project and run the following command: 
 ```shell
  laravel new awesome-project
  ```
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
 - Then install this package via composer:
 ```bash
composer require --dev samuelmwangiw/laravel-vite
```
 - Run `vite:install` command to setup vite
```shell
php artisan vite:install
```
 - Run `npm install` to install the dependencies and `npm run dev` to start the development server
 - Build your amazing project
 - Since samuelmwangiw/laravel-vite publishes all assets to your `App` namespace, it should be safe to remove the package from your dependencies

## Laravel Sail

If running [Sail](https://laravel.com/docs/9.x/sail) for local development, this package provides a handy `sail` npm script that runs `vite --host` under the hood as `vite` is only accessible via the loopback interface (127.0.0.1) by default and would therefore not be accessible in the docker container.

```bash
npm run sail
```

You may optionally publish the config if you connect to the docker host running vite via a custom address/port different from `http://host.docker.internal:3000`

```bash
php artisan vendor:publish --provider="SamuelMwangiW\Vite\ViteServiceProvider"
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
- [Sebastian De Deyne](https://sebastiandedeyne.com/vite-with-laravel/) whose blog inspired this package
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
