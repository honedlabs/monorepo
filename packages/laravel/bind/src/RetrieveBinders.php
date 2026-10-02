<?php

declare(strict_types=1);

namespace Honed\Bind;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class RetrieveBinders
{
    /**
     * Get the mapped model binders.
     *
     * @return array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<Binder>>>
     */
    public static function get(): array
    {
        if (App::bindersAreCached()) {
            return require App::getCachedBindersPath();
        }

        $binds = [];

        foreach (static::binders() as $binder) {
            static::bindings($binder, $binds);
        }

        return $binds;
    }

    /**
     * Put the binders into the cache.
     *
     * @param  array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<Binder>>>  $binds
     */
    public static function put(array $binds): void
    {
        $path = App::getCachedBindersPath();

        /** @var Filesystem $files */
        $files = App::make(Filesystem::class);

        $files->ensureDirectoryExists(dirname($path));

        // Atomic replace so a request cannot `require` a half-written map.
        $files->replace(
            $path,
            '<?php return '.var_export($binds, true).';'.PHP_EOL
        );
    }

    /**
     * Retrieve the discovered binders from the application.
     *
     * @return list<class-string<Binder>>
     */
    public static function binders(): array
    {
        $binders = [];

        foreach (App::getProviders(BindServiceProvider::class) as $provider) {
            foreach ($provider->getBinders() as $binder) {
                $binders[] = $binder;
            }
        }

        return array_values(array_unique($binders));
    }

    /**
     * Retrieve the bindings for the given binder, and push them to the array.
     *
     * @param  class-string<Binder>  $binder
     * @param  array<class-string<\Illuminate\Database\Eloquent\Model>, array<string, class-string<Binder>>>  $array
     */
    public static function bindings(string $binder, array &$array): void
    {
        /** @var Binder $binder */
        $binder = App::make($binder);

        $binds = array_fill_keys($binder->bindings(), get_class($binder));

        $model = $binder->modelName();

        $array[$model] = array_merge($array[$model] ?? [], $binds);
    }
}
