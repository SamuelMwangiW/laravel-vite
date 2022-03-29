<?php

namespace SamuelMwangiW\Vite\Commands;

use Illuminate\Console\Command;

class ViteCommand extends Command
{
    public $signature = 'laravel-vite';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
