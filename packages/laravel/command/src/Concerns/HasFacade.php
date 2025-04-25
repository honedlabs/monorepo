<?php

declare(strict_types=1);

namespace Honed\Command\Concerns;

use Symfony\Component\Console\Input\InputOption;

/**
 * @internal
 *
 * @phpstan-require-extends \Illuminate\Console\GeneratorCommand
 */
trait HasFacade
{
    /**
     * Get the console command options.
     *
     * @return array<int,array<int,mixed>>
     */
    public function facadeOption()
    {
        return [
            ['facade', 'f', InputOption::VALUE_NONE, 'Create a facade for the session'],
        ];
    }

    /**
     * Build the facade.
     *
     * @param  string  $name
     * @return void
     */
    public function buildFacade($name)
    {
        $name = ($this->qualifyClass($this->getNameInput()));

        $this->call('make:facade', [
            'name' => \class_basename($name),
            '--class' => $name,
            // @phpstan-ignore-next-line
            '--force' => $this->hasOption('force') && (bool) $this->option('force'),
        ]);
    }
}
