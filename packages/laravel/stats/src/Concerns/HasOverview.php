<?php

declare(strict_types=1);

namespace Honed\Stats\Concerns;

use Honed\Stats\Attributes\UseOverview;
use Honed\Stats\Overview;
use ReflectionClass;

/**
 * @template TOverview of \Honed\Stats\Overview
 *
 * @property-read class-string<TOverview> $overviewClass The overview for this model.
 */
trait HasOverview
{
    /**
     * Check if the method has been called statically.
     */
    private static function __isStatic(): bool
    {
        $backtrace = debug_backtrace();

        return $backtrace[1]['type'] === '::';
    }

    /**
     * Get the table instance for the model.
     *
     * @param  Closure|null  $before
     * @return TOverview
     */
    public static function overview()
    {
        $overview = static::newOverview()
            ?? Overview::overviewForModel(static::class);

        return $overview
            ->when(
                static::__isStatic(),
                fn (Overview $overview) => $overview->record($this)
            );
    }

    /**
     * Create a new table instance for the model.
     *
     * @return TOverview|null
     */
    protected static function newOverview()
    {
        return match (true) {
            isset(static::$overviewClass) => static::$overviewClass::make(),
            $overview = static::getUseOverviewAttribute() => $overview::make(),
            default => null,
        };
    }

    /**
     * Get the overview from the UseOverview class attribute.
     *
     * @return class-string<Overview>|null
     */
    protected static function getUseOverviewAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseOverview::class);

        if ($attributes !== []) {
            $useOverview = $attributes[0]->newInstance();

            $overview = $useOverview->overviewClass::make();

            $overview->guessOverviewNamesUsing(fn () => static::class);

            return $overview;
        }

        return null;
    }
}
