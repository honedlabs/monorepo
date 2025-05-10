<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\Orientation;

trait HasOrientation
{
    /**
     * The orientation to use.
     * 
     * @var string|null
     */
    protected $orientation;

    /**
     * The default orientation to be used.
     * 
     * @var string|null
     */
    protected static $defaultOrientation;

    /**
     * Set the orientation of the bar.
     * 
     * @param string|\Honed\Chart\Enums\Orientation $orientation
     * @return $this
     */
    public function orientation($orientation)
    {
        if (! $orientation instanceof Orientation) {
            $orientation = Orientation::tryFrom($orientation);
        }

        $this->orientation = $orientation?->value;

        return $this;
    }

    /**
     * Get the orientation of the bar.
     * 
     * @return string|null
     */
    public function getOrientation()
    {
        return $this->orientation ?? static::$defaultOrientation;
    }

    /**
     * Set the default orientation of the bar.
     * 
     * @param string $orientation
     * @return void
     */
    public static function useOrientation($orientation)
    {
        static::$defaultOrientation = $orientation;
    }

}