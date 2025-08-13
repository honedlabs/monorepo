<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasRGB;
use Stringable;

class Rgb implements Stringable
{
    use HasRGB;

    /**
     * Get the string representation of the RGB color.
     */
    public function __toString(): string
    {
        return "rgb({$this->getRed()}, {$this->getGreen()}, {$this->getBlue()})";
    }

    /**
     * Create a new RGB instance.
     */
    public static function make(int $red = 0, int $green = 0, int $blue = 0): static
    {
        return resolve(static::class)
            ->red($red)
            ->green($green)
            ->blue($blue);
    }

    /**
     * Get the string representation of the RGB color.
     *
     * @see \Honed\Chart\Style\Rgb::__toString()
     */
    public function toString(): string
    {
        return $this->__toString();
    }

    /**
     * Get the string representation of the RGB color.
     *
     * @see \Honed\Chart\Style\Rgb::__toString()
     */
    public function value(): string
    {
        return $this->__toString();
    }
}
