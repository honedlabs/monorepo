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
        return $this->padding ?? static::$defaultPadding;
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

    /**
     * Flush the state of the padding.
     * 
     * @return void
     */
    public static function flushPaddingState()
    {
        static::$defaultPadding = null;
    }

    /**
     * Get whether to exclude the series from the domain calculation as an 
     * array.
     * 
     * @return array<string, mixed>
     */
    public function paddingToArray()
    {
        return [
            'padding' => $this->getPadding()
        ];
    }
}