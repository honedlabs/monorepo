<?php

declare(strict_types=1);

namespace Honed\Registry\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'registry:item')]
class RegistryItemMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'registry:item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new registry item.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Registry item';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.registry-item.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(\trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../../..'.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Registry\Items';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the item even if the registry item already exists'],
        ];
    }

    /**
     * Registry for missing input arguments using the returned questions.
     *
     * @return array<string,mixed>
     */
    protected function registryForMissingArgumentsUsing()
    {
        return [
            'name' => [
                'What should the '.strtolower($this->type).' be named?',
                'E.g. Button',
            ],
        ];
    }
}