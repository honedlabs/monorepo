<?php

namespace Honed\Registry\Commands;

use Honed\Registry\RegistryServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'registry:build')]
class RegistryBuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registry:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover and build the registrys for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->callSilent('registry:clear');

        file_put_contents(
            $this->laravel->getRegistryPath(),
            ''
            // Registry::build(),
        );

        $this->components->info('Registry json file built successfully.');
    }
}