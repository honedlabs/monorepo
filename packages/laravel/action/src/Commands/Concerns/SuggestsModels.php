<?php

declare(strict_types=1);

namespace Honed\Action\Commands\Concerns;

use function in_array;
use function Laravel\Prompts\confirm;

use InvalidArgumentException;

use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;

/**
 * @phpstan-require-extends \Illuminate\Console\GeneratorCommand
 */
trait SuggestsModels
{
    /**
     * Get a list of possible model names.
     *
     * @return array<int, string>
     */
    protected function possibleModels()
    {
        $modelPath = is_dir(app_path('Models')) ? app_path('Models') : app_path();

        return (new Collection(Finder::create()->files()->depth(0)->in($modelPath)))
            ->map(fn ($file) => $file->getBasename('.php'))
            ->sort()
            ->values()
            ->all();
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    /**
     * Prompt the user to create a model if it does not exist.
     *
     * @param  string  $modelClass
     * @return void
     */
    protected function promptForModelCreation($modelClass)
    {
        $modelPath = $this->getModelPath($modelClass);
        
        if (
            ! file_exists($modelPath)
            && confirm("A [{$modelClass}] model does not exist. Do you want to generate it?", default: true)
        ) {
            $this->call('make:model', ['name' => $modelClass]);
        }
    }

    /**
     * Get the file path for the model class.
     *
     * @param  string  $modelClass
     * @return string
     */
    protected function getModelPath($modelClass)
    {
        $modelName = class_basename($modelClass);
        $modelPath = is_dir(app_path('Models')) ? app_path('Models') : app_path();
        
        return $modelPath . '/' . $modelName . '.php';
    }
}
