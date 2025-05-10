<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasLines
{
    /**
     * The thickness of the line in pixels.
     * 
     * @var int|null
     */
    protected $lineWidth;

    /**
     * The default thickness of the line in pixels.
     * 
     * @var int
     */
    protected static $defaultLineWidth = 2;

    /**
     * The dashed line.
     * 
     * @var bool|null
     */
    protected $dashed;

    /**
     * Set the lineWidth of the animation.
     * 
     * @param int|null $lineWidth
     * @return $this
     */
    public function lineWidth($lineWidth)
    {
        $this->lineWidth = $lineWidth;

        return $this;
    }

    /**
     * Get the lineWidth of the animation.
     * 
     * @return int|null
     */
    public function getLineWidth()
    {
        return $this->lineWidth ?? static::$defaultLineWidth;
    }

    /**
     * Set the default lineWidth of the animation.
     * 
     * @param int $lineWidth
     * @return void
     */
    public static function useLineWidth($lineWidth)
    {
        static::$defaultLineWidth = $lineWidth;
    }
}