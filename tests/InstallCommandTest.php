<?php

use Illuminate\Support\Facades\File;
use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;

it(description: 'runs console command vite:install')
    ->artisan('vite:install')
    ->expectsConfirmation('This action will overwrite some files and cannot be undone. Are you sure?', 'no')
    ->expectsOutput('Phew... That was close!')
    ->assertSuccessful();

it(description: 'runs the installation')
    ->artisan('vite:install')
    ->expectsConfirmation('This action will overwrite some files and cannot be undone. Are you sure?', 'yes')
    ->expectsOutput('Setup Done. ')
    ->expectsOutput('Run `npm install && npm run dev`')
    ->assertSuccessful();

it('publishes assets', function () {
    artisan('vite:install')
        ->expectsConfirmation('This action will overwrite some files and cannot be undone. Are you sure?', 'yes')
        ->assertSuccessful();

    assertFileExists(resource_path('views/app.blade.php'));
    assertFileExists(resource_path('js/app.js'));
    assertFileExists(resource_path('js/bootstrap.js'));
    assertFileExists(base_path('package.json'));
    assertFileExists(base_path('postcss.config.js'));
    assertFileExists(base_path('tailwind.config.js'));
    assertFileExists(base_path('vite.config.js'));
    assertFileExists(app_path('Utils/Vite.php'));
    assertFileExists(app_path('Providers/ViteServiceProvider.php'));
    assertFileExists(config_path('vite.php'));
});


it('deletes webpack and laravel-mix assets', function () {
    File::put(base_path('webpack.mix.js'), '//dummy content');
    File::put(base_path('webpack.config.js'), '//dummy content');
    File::put(public_path('mix-manifest.json'), '//dummy content');

    $this->artisan('vite:install')
        ->expectsConfirmation(
            question: 'This action will overwrite some files and cannot be undone. Are you sure?',
            answer: 'yes'
        )->assertSuccessful();

    assertFileDoesNotExist(base_path('webpack.mix.js'));
    assertFileDoesNotExist(base_path('webpack.config.js'));
    assertFileDoesNotExist(public_path('mix-manifest.json'));
});
