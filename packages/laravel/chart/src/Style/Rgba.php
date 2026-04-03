<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Exception;
use Honed\Chart\Style\Concerns\HasRGB;
use Stringable;

class Rgba implements Stringable
{
    use HasRGB;

    /**
     * The alpha component of the color.
     *
     * @var int
     */
    protected $alpha = 1;

    /**
     * Set the alpha component of the color.
     *
     * @return $this
     */
    public function alpha(int $alpha): static
    {
        if ($alpha < 0 || $alpha > 1) {
            throw new Exception('Alpha must be between 0 and 1');
        }

        $this->alpha = $alpha;

        return $this;
    }

    /**
     * Get the alpha component of the color.
     */
    public function getAlpha(): int
    {
        return $this->alpha;
    }

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
    public static function make(
        int $red = 0,
        int $green = 0,
        int $blue = 0,
        int $alpha = 1
    ): static {

        return app(static::class)
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
