<?php

declare(strict_types=1);

namespace Honed\Bind;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class DiscoverBinders
{
    /**
     * The callback to be used to guess class names.
     *
     * @var (callable(SplFileInfo, string): class-string)|null
     */
    public static $guessClassNamesUsingCallback;

    /**
     * Get all of the binders by searching the given binder directory.
     *
     * @param  array<int, string>|string  $binderPath
     * @param  string  $basePath
     * @return array<int, class-string<Binder>>
     */
    public static function within($binderPath, $basePath)
    {
        if (Arr::wrap($binderPath) === []) {
            return [];
        }

        $files = Finder::create()->files()->in($binderPath);

        /** @var array<int, class-string<Binder>> $binders */
        $binders = [];

        foreach ($files as $file) {
            $binder = static::classFromFile($file, $basePath);

            if (static::invalidBinder($binder)) {
                continue;
            }

            /** @var class-string<Binder> $binder */
            $binders[] = $binder;
        }

        return $binders;
    }

    /**
     * Specify a callback to be used to guess class names.
     *
     * @param  callable(SplFileInfo, string): class-string  $callback
     * @return void
     */
    public static function guessClassNamesUsing(callable $callback)
    {
        static::$guessClassNamesUsingCallback = $callback;
    }

    /**
     * Determine if the binder is invalid.
     *
     * @param  string  $binder
     * @return bool
     */
    protected static function invalidBinder($binder)
    {
        return ! class_exists($binder)
            || ! is_subclass_of($binder, Binder::class)
            || ! (new ReflectionClass($binder))->isInstantiable();
    }

    /**
     * Extract the class name from the given file path.
     *
     * @param  string  $basePath
     * @return string
     */
    protected static function classFromFile(SplFileInfo $file, $basePath)
    {
        if (static::$guessClassNamesUsingCallback) {
            return call_user_func(static::$guessClassNamesUsingCallback, $file, $basePath);
        }

        $class = trim(Str::replaceFirst($basePath, '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        return ucfirst(Str::camel(str_replace(
            [DIRECTORY_SEPARATOR, ucfirst(basename(App::path())).'\\'],
            ['\\', App::getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        )));
    }
}
