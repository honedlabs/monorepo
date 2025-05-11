<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasWidth
{
    /**
     * The width in pixels.
     * 
     * @var int|null
     */
    protected $width;

    /**
     * Set the width in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function width($pixels)
    {
        $this->width = $pixels;

        return $this;
    }

    /**
     * Get the width in pixels.
     * 
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }
}