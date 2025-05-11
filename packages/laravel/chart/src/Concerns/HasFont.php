<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasFont
{
    /**
     * The font size in pixels.
     * 
     * @var int|null
     */
    protected $fontSize;

    /**
     * The default font size in pixels.
     * 
     * @var int|null
     */
    protected static $defaultFontSize;

    /**
     * Set the font size in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function fontSize($pixels)
    {
        $this->fontSize = $pixels;

        return $this;
    }

    /**
     * Get the font size in pixels.
     * 
     * @return int|null
     */
    public function getFontSize()
    {
        $font = $this->fontSize ?? static::$defaultFontSize;

        return $font;
    }

    /**
     * Set the font size in pixels by default.
     * 
     * @param int $pixels
     * @return void
     */
    public static function useFontSize($pixels)
    {
        static::$defaultFontSize = $pixels;
    }

    /**
     * Flush the state of the font size.
     * 
     * @return void
     */
    public static function flushFontState()
    {
        static::$defaultFontSize = null;
    }
}