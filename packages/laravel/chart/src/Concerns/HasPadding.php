<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasPadding
{
    /**
     * The padding of the element in pixels.
     * 
     * @var int|null
     */
    protected $padding;

    /**
     * The padding of the element in pixels by default.
     * 
     * @var int|null
     */
    protected static $defaultPadding;

    /**
     * Set the padding in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function padding($pixels)
    {
        $this->padding = $pixels;

        return $this;
    }

    /**
     * Set the padding in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function pad($pixels)
    {
        return $this->padding($pixels);
    }

    /**
     * Get the padding in pixels.
     * 
     * @return int|null
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * Set the padding in pixels by default.
     * 
     * @param int $pixels
     * @return void
     */
    public static function usePadding($pixels)
    {
        static::$defaultPadding = $pixels;
    }
}