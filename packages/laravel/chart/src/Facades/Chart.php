<?php

declare(strict_types=1);

namespace Honed\Chart\Facades;

use Honed\Chart\ChartFactory;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Chart\ChartFactory
 */
class Chart extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return \Honed\Chart\ChartFactory
     */
    public static function getFacadeRoot()
    {
        // @phpstan-ignore-next-line
        return parent::getFacadeRoot();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ChartFactory::class;
    }
}