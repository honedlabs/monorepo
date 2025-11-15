<?php

declare(strict_types=1);

namespace Honed\Scaffold\Scaffolders;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use SplFileInfo;

use function Laravel\Prompts\select;

class PropertyScaffolder extends Scaffolder
{
    /**
     * Determine if the scaffolder is applicable to the context and should be executed.
     */
    public function isApplicable(): bool
    {
        return true;
    }

    /**
     * Prompt the user for input.
     */
    public function prompt(): void
    {
        $properties = $this->getPropertyOptions();

        while (true) {
            /** @var class-string<\Honed\Scaffold\Contracts\Property>|'none' */
            $selected = select('Select a property type', [
                'none' => 'None',
                ...$properties,
            ]);

            if ($selected === 'none') {
                break;
            }

            $property = $selected::make();

            $property->prompt();

            $this->components->success("A new \"{$property->getColumn()}\" property \"{$property->getName()}\" has been added to the model.");

            $this->addProperty($property);
        }
    }

    /**
     * Get the property options.
     *
     * @return array<class-string<\Honed\Scaffold\Contracts\Property>, string>
     */
    protected function getPropertyOptions(): array
    {
        return (new Collection(File::allFiles(__DIR__.'/../Properties')))
            ->map(fn (SplFileInfo $file) => new ReflectionClass(Str::of($file->getBasename())
                ->beforeLast('.php')
                ->prepend(Str::beforeLast(__NAMESPACE__, 'Scaffolder').'Properties\\')
                ->toString()
            ))
            ->reject(fn (ReflectionClass $class) => ! $class->isInstantiable())
            ->mapWithKeys(function (ReflectionClass $class) {
                /** @var class-string<\Honed\Scaffold\Contracts\Property> */
                $name = $class->getName();

                $label = Str::of($class->getShortName())
                    ->beforeLast('Property')
                    ->slug()
                    ->title()
                    ->toString();

                return [
                    $name => $label,
                ];
            })
            ->toArray();

    }
}
