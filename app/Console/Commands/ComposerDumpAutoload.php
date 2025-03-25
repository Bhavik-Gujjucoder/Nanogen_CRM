<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class ComposerDumpAutoload extends Command
{
    protected $signature = 'composer:dump-autoload';
    protected $description = 'Run composer dump-autoload';

    public function handle()
    {
        $output = shell_exec('composer dump-autoload');

        if ($output) {
            $this->info($output);
        } else {
            $this->error('Command failed. Check server permissions.');
        }
    }
}
