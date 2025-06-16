<?php

declare(strict_types=1);

namespace Honed\List\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

use function class_basename;
use function file_get_contents;
use function in_array;
use function mb_strtolower;
use function mb_trim;
use function sprintf;
use function str_replace;

#[AsCommand(name: 'make:list')]
class ListMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new list class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'List';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/honed.list.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(mb_trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Lists';
    }

    /**
     * Get the console command options
     *
     * @return array<int,array<int,mixed>>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the list already exists'],
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model that the list should be for.'],
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
                'What should the '.mb_strtolower($this->type).' be named?',
                'E.g. UserList',
            ],
        ];
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceModel($stub)
            ->insertList($name)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the template TModel of the list.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceModel(&$stub)
    {
        $searches = ['DummyModel', '{{ model }}', '{{ Model }}', '{{model}}', '{{Model}}'];

        /** @var string|null */
        $model = $this->option('model');

        if (! $model) {
            $model = '\\Illuminate\\Database\\Eloquent\\Model';
        } elseif (in_array($model, $this->possibleModels())) {
            $model = '\\'.$this->qualifyModel($model);
        } else {
            $this->error('The model '.$model.' does not exist.');

            return $this;
        }

        $stub = str_replace($searches, $model, $stub);

        return $this;
    }

    /**
     * Insert the type hinting of the new list into the model file.
     *
     * @param  string  $name
     * @return $this
     */
    protected function insertList($name)
    {
        /** @var string|null */
        $model = $this->option('model');

        if (! $model || ! in_array($model, $this->possibleModels())) {
            return $this;
        }

        $path = app_path('Models/'.$model.'.php');
        $stub = file_get_contents($path);

        if (! $stub) {
            $this->error('The model '.$model.' does not exist.');

            return $this;
        }

        // Add use statement for the list
        $stub = str_replace(
            "use Illuminate\Database\Eloquent\Model;\n",
            "use Illuminate\Database\Eloquent\Model;\nuse ".$name.";\n",
            $stub
        );

        // Find the end of the model class by the last closing brace
        $classEnd = mb_strrpos($stub, '}');

        if ($classEnd) {
            $inserts = $this->getInserts($name, $model);

            // Insert the variable before the closing brace
            $stub = substr_replace(
                $stub,
                $inserts,
                $classEnd,
                0
            );
        }

        $this->files->put($path, $this->sortImports($stub));

        return $this;
    }
}