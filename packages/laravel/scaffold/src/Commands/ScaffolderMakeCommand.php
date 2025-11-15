<?php

declare(strict_types=1);

namespace Honed\Scaffold\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'honed:scaffolder')]
class ScaffolderMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'honed:scaffolder';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $description = 'Create a new scaffolder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Scaffolder';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/honed.scaffolder.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Support\Scaffolders';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions(): array
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the '.mb_strtolower($this->type).' already exists'],
        ];
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string,mixed>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => [
                'What should the '.strtolower($this->type).' be named?',
                'E.g. CustomScaffolder',
            ],
        ];
    }
}
