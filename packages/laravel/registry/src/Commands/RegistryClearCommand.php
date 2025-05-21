<?php

namespace Honed\Registry\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'registry:clear')]
class RegistryClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'registry:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cached registry.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->files->delete($this->laravel->getRegistryPath());

        $this->components->info('Registry json file cleared successfully.');
    }
}