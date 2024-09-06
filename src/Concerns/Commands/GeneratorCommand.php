<?php

declare(strict_types=1);

namespace Conquest\Command\Commands;

use ReflectionClass;
use Illuminate\Console\Command;
use Conquest\Core\Concerns\ManipulatesFiles;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Contracts\Console\PromptsForMissingInput;

abstract class GeneratorCommand extends Command implements PromptsForMissingInput
{
    use ManipulatesFiles;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, sprintf('The name of the %s to generate.', strtolower($this->type))],
            ['method', InputArgument::OPTIONAL, sprintf('The method of the %s to use.', strtolower($this->type))],
        ];
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => [
                sprintf('What should the %s be named?', strtolower($this->type)),
                sprintf('E.g. User%s%s', in_array('method', array_column($this->getArguments(), 0)) ? 'Show' : '', $this->type),
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, sprintf('Create the %s even if it already exists.', strtolower($this->type))],
        ];
    }

    protected function getDefaultStubPath(): string
    {
        $reflectionClass = new ReflectionClass($this);

        return (string) str($reflectionClass->getFileName())
            ->beforeLast('Commands')
            ->append('../stubs');
    }
}
