<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class InstallCommand extends Command
{
    protected $signature = 'app:install {--fresh : Drop tables before running migrations} {--no-build : Preskoci npm build}';

    protected $description = 'Priprema aplikaciju nakon composer install-a';

    public function handle()
    {
        $this->info("🚀 Pokrećem instalaciju aplikacije...");

        // Laravel key
        if (!file_exists(storage_path('framework/laravel-exists'))) {
            $this->info("🔑 Generišem app key...");
            $this->runProcess('php artisan key:generate');
        }

        // Storage link
        $this->info("🔗 Kreiram storage symlink...");
        $this->runProcess('php artisan storage:link');

        // Migracije
        if ($this->option('fresh')) {
            $this->info("🧨 Pokrećem fresh migracije...");
            $this->runProcess('php artisan migrate:fresh --seed');
        } else {
            $this->info("📚 Pokrećem migracije...");
            $this->runProcess('php artisan migrate --seed');
        }

        // NPM build
        if (! $this->option('no-build')) {
            $this->info("🎨 Radim npm build...");
            $this->runProcess('npm run build');
        } else {
            $this->info("⏭ Preskačem npm build (--no-build)");
        }

        $this->info("⚡ Čišćenje keša...");
        $this->runProcess('php artisan optimize:clear');

        $this->info("🎉 Instalacija završena!");
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
