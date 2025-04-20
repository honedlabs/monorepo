<?php

declare(strict_types=1);

namespace Honed\Command\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:partial')]
class PartialMakeCommand extends JsMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:partial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Javascript partial.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Partial';

    /**
     * The default extension for the partial.
     *
     * @var string
     */
    protected $extension = 'vue';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $ext = $this->getExtension();

        return $this->resolveStubPath("/stubs/honed.partial.{$ext}.stub");
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        dd($rootNamespace);
        return $rootNamespace.'\Partials';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['extension', 'e', InputOption::VALUE_OPTIONAL, 'The file extension of the partial, defaults to .vue'],
            ['force', null, InputOption::VALUE_NONE, 'Create the partial even if it already exists'],
        ];
    }

    /**
     * Get the extension to use for the partial.
     *
     * @return string|null
     */
    protected function getExtension()
    {
        /** @var string|null $ext */
        $extension = $this->option('extension');

        if ($extension) {
            return \trim($ext, '.');
        }

        return $this->extension;
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string,mixed>
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => [
                'What should the '.\mb_strtolower($this->type).' be named?',
                'E.g. UserCard',
            ],
        ];
    }
}
