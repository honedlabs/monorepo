<?php

declare(strict_types=1);

namespace Honed\Core\Commands;

use Honed\Core\Concerns\ManipulatesFiles;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Stringable;
use ReflectionClass;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class GeneratorCommand extends Command implements PromptsForMissingInput
{
    use ManipulatesFiles;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * Retrieve the arguments for the command.
     *
     * @return array<int,array{string,int,string}>
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, sprintf('The name of the %s to generate.', strtolower($this->type))],
            ['method', InputArgument::OPTIONAL, sprintf('The method of the %s to use.', strtolower($this->type))],
        ];
    }

    /**
     * Retrieve the arguments for the command.
     *
     * @return array{'name':array{string,string}}
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => [
                sprintf('What should the %s be named?', strtolower($this->type)),
                sprintf('E.g. User%s%s', in_array('method', array_column($this->getArguments(), 0)) ? 'Show' : '', $this->type),
            ],
        ];
    }

    /**
     * Retrieve the options for the command.
     *
     * @return array<int,array{string,string,int,string}>
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, sprintf('Create the %s even if it already exists.', strtolower($this->type))],
        ];
    }

    /**
     * Retrieve the default stub path for the command.
     */
    protected function getDefaultStubPath(): string
    {
        $reflectionClass = new ReflectionClass($this);

        return (new Stringable((string) $reflectionClass->getFileName()))
            ->beforeLast('Commands')
            ->append('../stubs')
            ->value();
    }
}
