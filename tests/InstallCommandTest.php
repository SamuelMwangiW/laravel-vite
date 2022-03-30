<?php

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
