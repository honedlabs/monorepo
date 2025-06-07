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
    public static function get()
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
     * @return void
     */
    public static function put($binds)
    {
        file_put_contents(
            App::getCachedBindersPath(),
            '<?php return '.var_export($binds, true).';'
        );
    }

    /**
     * Retrieve the discovered binders from the application.
     *
     * @return array<class-string<Binder>>
     */
    public static function binders()
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
     * @return void
     */
    public static function bindings($binder, &$array)
    {
        /** @var Binder $binder */
        $binder = App::make($binder);

        $binds = array_fill_keys($binder->bindings(), get_class($binder));

        $model = $binder->modelName();

        $array[$model] = array_merge($array[$model] ?? [], $binds);
    }
}
