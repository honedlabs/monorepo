<?php

declare(strict_types=1);

namespace Honed\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

abstract class ListCommand extends Command
{
    /**
     * Get the paths to search for classes.
     *
     * @return class-string|array<int, class-string>
     */
    abstract protected function paths(): string|array;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $classes = (new Collection($this->classes()))
            ->sortBy(static fn ($model) => get_class($model));

        if ($classes->isEmpty()) {
            $this->components->info('No matching classes found');

            return;
        }

        $this->newLine();
        $this->displayForCli($classes);
        $this->newLine();
    }

    /**
     * Get the classes.
     *
     * @return array<int, object>
     */
    protected function classes(): array
    {
        return (new Collection(Arr::wrap($this->paths())))
            ->flatMap(function (string $path): array {
                $directory = glob($path, GLOB_ONLYDIR);

                return $directory ?: [];
            })
            ->reject(function (string $directory): bool {
                return ! is_dir($directory);
            })
            ->pipe(function (Collection $collection): array {
                /** @var array<int, class-string> $classes */
                $classes = $collection->all();

                return $this->within($classes);
            });
    }

    /**
     * Get the classes within the given paths.
     *
     * @param  class-string|array<int, class-string>  $paths
     * @return array<int, object>
     */
    protected function within(string|array $paths): array
    {
        if (Arr::wrap($paths) === []) {
            return [];
        }

        $files = Finder::create()->files()->in($paths);

        $classes = [];

        foreach ($files as $file) {
            $class = $this->classFromFile($file);

            if ($this->ignore($class)) {
                continue;
            }

            $classes[] = app()->make($class);
        }

        return $classes;
    }

    /**
     * Determine if the class should be ignored.
     */
    protected function ignore(string $class): bool
    {
        return ! class_exists($class) || ! (new ReflectionClass($class))->isInstantiable();
    }

    /**
     * Extract the class name from the file.
     */
    protected function classFromFile(SplFileInfo $file): string
    {
        $class = trim(Str::replaceFirst($this->basePath(), '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        return ucfirst(Str::camel(str_replace(
            [DIRECTORY_SEPARATOR, ucfirst(basename(app()->path())).'\\'],
            ['\\', $this->namespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        )));
    }

    /**
     * Get the application namespace.
     */
    protected function namespace(): string
    {
        return app()->getNamespace();
    }

    /**
     * Get the base path of the application.
     */
    protected function basePath(): string
    {
        return base_path();
    }

    /**
     * Display the classes for the CLI.
     *
     * @param  Collection<int, object>  $classes
     */
    protected function displayForCli(Collection $classes): void
    {
        $classes->each(function ($class) {
            $this->components->twoColumnDetail(get_class($class));
        });
    }

    /**
     * Determine if the class does not implement the interface.
     *
     * @param  class-string  $class
     * @param  class-string|array<int, class-string>  $interface
     */
    protected function doesNotImplement(string $class, string|array $interface): bool
    {
        foreach ((array) $interface as $interface) {
            if (in_array($interface, $this->getInterfaces($class))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the class does not use the trait.
     *
     * @param  class-string  $class
     * @param  class-string|array<int, class-string>  $trait
     */
    protected function doesNotUse(string $class, string|array $trait): bool
    {
        foreach ((array) $trait as $trait) {
            if (in_array($trait, $this->getTraits($class))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the class does not extend the class.
     *
     * @param  class-string  $class
     * @param  class-string  $parent
     */
    protected function doesNotExtend(string $class, string $parent): bool
    {
        return ! in_array($parent, $this->getClasses($class));
    }

    /**
     * Get all traits of the class and parents.
     *
     * @param  class-string  $class
     * @return array<int, class-string>
     */
    protected function getTraits(string $class): array
    {
        /** @var array<int, class-string> */
        return class_uses_recursive($class);
    }

    /**
     * Get all interfaces of the class and parents.
     *
     * @param  class-string  $class
     * @return array<int, class-string>
     */
    protected function getInterfaces(string $class): array
    {
        /** @var array<int, class-string> $interfaces */
        $interfaces = [];

        do {
            $interfaces = array_merge($interfaces, class_implements($class) ?: []);
        } while ($class = get_parent_class($class));

        /** @var array<int, class-string> */
        return $interfaces;
    }

    /**
     * Get the classes that inherit from the given class.
     *
     * @param  class-string  $class
     * @return array<int, class-string>
     */
    protected function getClasses(string $class): array
    {
        $classes = class_parents($class);

        // @phpstan-ignore-next-line return.type
        return $classes ?: [];
    }
}
