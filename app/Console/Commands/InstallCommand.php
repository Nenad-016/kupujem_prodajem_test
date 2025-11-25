<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class InstallCommand extends Command
{
    protected $signature = 'app:install {--fresh : Drop tables before running migrations}';

    protected $description = 'Priprema aplikaciju nakon composer install-a';

    public function handle()
    {
        $this->info('🚀 Pokrećem instalaciju aplikacije...');

        // Laravel key (samo prvi put)
        if (! file_exists(storage_path('framework/laravel-exists'))) {
            $this->info('🔑 Generišem app key...');
            $this->runProcess('php artisan key:generate');

            file_put_contents(
                storage_path('framework/laravel-exists'),
                now()->toDateTimeString()
            );
        }

        // Storage link
        $this->info('🔗 Kreiram storage symlink...');
        $this->runProcess('php artisan storage:link');

        // Migracije
        if ($this->option('fresh')) {
            $this->info('🧨 Pokrećem fresh migracije...');
            $this->runProcess('php artisan migrate:fresh --seed');
        } else {
            $this->info('📚 Pokrećem migracije...');
            $this->runProcess('php artisan migrate --seed');
        }

        // NPM build – ne koristimo Vite
        $this->info('⏭ Preskačem npm build (Vite se ne koristi u projektu)');

        // Cache & autoload
        $this->info('⚡ Čišćenje keša...');
        $this->runProcess('php artisan optimize:clear');
        $this->runProcess('composer dump-autoload');

        $this->info('🎉 Instalacija završena!');

        return Command::SUCCESS;
    }

    private function runProcess($command)
    {
        $process = Process::path(base_path())->run($command);

        if ($process->successful()) {
            $this->line($process->output());
        } else {
            $this->error($process->errorOutput());
            exit(1);
        }
    }
}
