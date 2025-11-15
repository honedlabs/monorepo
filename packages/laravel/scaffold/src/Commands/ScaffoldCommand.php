<?php

declare(strict_types=1);

namespace Honed\Scaffold\Commands;

use Honed\Scaffold\Support\ScaffoldContext;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'honed:scaffold')]
class ScaffoldCommand extends Command implements PromptsForMissingInput
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'honed:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold out the necessary boilerplate for your model.';

    /**
     * Reserved names that cannot be used for generation.
     *
     * @var string[]
     */
    protected $reservedNames = [
        '__halt_compiler',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'enum',
        'eval',
        'exit',
        'extends',
        'false',
        'final',
        'finally',
        'fn',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'match',
        'namespace',
        'new',
        'or',
        'parent',
        'print',
        'private',
        'protected',
        'public',
        'readonly',
        'require',
        'require_once',
        'return',
        'self',
        'static',
        'switch',
        'throw',
        'trait',
        'true',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
        'yield',
        '__CLASS__',
        '__DIR__',
        '__FILE__',
        '__FUNCTION__',
        '__LINE__',
        '__METHOD__',
        '__NAMESPACE__',
        '__TRAIT__',
    ];

    /**
     * Execute the console command
     *
     * @return bool|null
     */
    public function handle()
    {
        if ($this->isReservedName($name = $this->getNameInput())) {
            $this->components->error("The name \"{$name}\" is reserved by PHP.");

            return false;
        }

        $this->components->info('Scaffolding model...');

        $context = $this->createContext($name);

        foreach ($context->getScaffolders($this) as $scaffolder) {
            if (! $scaffolder->isApplicable()) {
                continue;
            }

            $scaffolder->prompt();
        }

        $context->generate();

        $this->components->success('Scaffolding complete.');

        return null;
    }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): string
    {
        $name = trim($this->argument('name'));

        if (Str::endsWith($name, '.php')) {
            return Str::substr($name, 0, -4);
        }

        return $name;
    }

    /**
     * Checks whether the given name is reserved.
     */
    protected function isReservedName(string $name): bool
    {
        return in_array(
            strtolower($name),
            (new Collection($this->reservedNames))
                ->transform(fn ($name) => strtolower($name))
                ->all()
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return list<list<mixed>>
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return list<list<mixed>>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
        ];
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
                'What should the model be named?',
                'E.g. Flight',
            ],
        ];
    }

    /**
     * Create a new scaffold context instance.
     */
    protected function createContext(string $name): ScaffoldContext
    {
        return ScaffoldContext::make($name);
    }
}
