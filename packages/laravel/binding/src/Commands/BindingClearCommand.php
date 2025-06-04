<?php

declare(strict_types=1);

namespace Honed\Binding\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'binding:clear')]
class BindingClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'binding:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the cached application bindingss.';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
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
        $this->files->delete($this->laravel->getCachedBindersPath());

        $this->components->info('Cached binding methods cleared successfully.');
    }
}
