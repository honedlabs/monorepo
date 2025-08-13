<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasAlpha;
use Honed\Chart\Style\Concerns\HasRGB;
use Stringable;

class Rgba implements Stringable
{
    use HasAlpha;
    use HasRGB;

    /**
     * Get the string representation of the RGBA color.
     */
    public function __toString(): string
    {
        return "rgba({$this->getRed()}, {$this->getGreen()}, {$this->getBlue()}, {$this->getAlpha()})";
    }

    /**
     * Create a new RGBA instance.
     */
    public static function make(int $red = 0, int $green = 0, int $blue = 0, int $alpha = 1): static
    {
        return resolve(static::class)
            ->red($red)
            ->green($green)
            ->blue($blue)
            ->alpha($alpha);
    }

    /**
     * Get the string representation of the RGBA color.
     *
     * @see \Honed\Chart\Style\Rgba::__toString()
     */
    public function toString(): string
    {
        return $this->__toString();
    }

    /**
     * Get the string representation of the RGBA color.
     *
     * @see \Honed\Chart\Style\Rgba::__toString()
     */
    public function value(): string
    {
        return $this->__toString();
    }
}
