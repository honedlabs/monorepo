<?php

declare(strict_types=1);

namespace Honed\Bind;

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
        file_put_contents(
            App::getCachedBindersPath(),
            '<?php return '.var_export($binds, true).';'
        );
    }

    /**
     * Retrieve the discovered binders from the application.
     *
     * @return array<int, class-string<Binder>>
     */
    public static function binders(): array
    {
        $binders = [];

        foreach (App::getProviders(BindServiceProvider::class) as $provider) {
            $binders = \array_merge($binders, $provider->getBinders());
        }

        return $binders;
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
