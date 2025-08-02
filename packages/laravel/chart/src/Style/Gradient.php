<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasColorStops;
use Honed\Chart\Style\Concerns\HasGradientType;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class Gradient implements Arrayable
{
    use HasGradientType;
    use HasColorStops;

    /**
     * The first x coordinate.
     * 
     * @var float|int
     */
    protected $x1 = 0;

    /**
     * The first y coordinate.
     * 
     * @var float|int
     */
    protected $y1 = 0;

    /**
     * The second x coordinate.
     * 
     * @var float|int
     */
    protected $x2 = 0;

    /**
     * The second y coordinate.
     * 
     * @var float|int
     */
    protected $y2 = 0;

    /**
     * Set the first x coordinate.
     * 
     * @return $this
     * 
     * @throws \InvalidArgumentException if the coordinate is not between 0 and 1
     */
    public function x(float|int $value): static
    {
        if ($value < 0 || $value > 1) {
            $this->invalidRange('X1');
        }

        $this->x1 = $value;

        return $this;
    }

    /**
     * Set the first x coordinate.
     * 
     * @return $this
     * 
     * @throws \InvalidArgumentException if the coordinate is not between 0 and 1
     * 
     * @see \Honed\Chart\Style\Gradient::getX()
     */
    public function x1(float|int $value): static
    {
        return $this->x($value);
    }

    /**
     * Get the first x coordinate.
     */
    public function getX(): float|int
    {
        return $this->x1;
    }

    /**
     * Get the first x coordinate
     * 
     * @see \Honed\Chart\Style\Gradient::getX()
     */
    public function getX1(): float|int
    {
        return $this->getX();
    }

    /**
     * Set the first y coordinate.
     * 
     * @return $this
     * 
     * @throws \InvalidArgumentException if the coordinate is not between 0 and 1
     */
    public function y(float|int $value): static
    {
        if ($value < 0 || $value > 1) {
            $this->invalidRange('Y1');
        }

        $this->y1 = $value;

        return $this;
    }

    /**
     * Set the first y coordinate.
     * 
     * @return $this
     * 
     * @see \Honed\Chart\Style\Gradient::getY()
     */
    public function y1(float|int $value): static
    {
        return $this->y($value);
    }

    /**
     * Get the first y coordinate.
     */
    public function getY(): float|int
    {
        return $this->y1;
    }

    /**
     * Get the first y coordinate.
     * 
     * @see \Honed\Chart\Style\Gradient::getY()
     */
    public function getY1(): float|int
    {
        return $this->getY();
    }

    /**
     * Set the second x coordinate.
     * 
     * @return $this
     * 
     * @throws \InvalidArgumentException if the coordinate is not between 0 and 1
     */
    public function x2(float|int $value): static
    {
        if ($value < 0 || $value > 1) {
            $this->invalidRange('X2');
        }

        $this->x2 = $value;

        return $this;
    }

    /**
     * Get the second x coordinate.
     */
    public function getX2(): float|int
    {
        return $this->x2;
    }

    /**
     * Set the second y coordinate.
     * 
     * @return $this
     * 
     * @throws \InvalidArgumentException if the coordinate is not between 0 and 1
     */
    public function y2(float|int $value): static
    {
        if ($value < 0 || $value > 1) {
            $this->invalidRange('Y2');
        }

        $this->y2 = $value;

        return $this;
    }

    /**
     * Get the second y coordinate.
     */
    public function getY2(): float|int
    {
        return $this->y2;
    }

    /**
     * Set the linear gradient direction to be from bottom to top.
     * 
     * @return $this
     */
    public function toTop(): static
    {
        return $this->x(0)->x2(0)->y(1)->y2(0);
    }

    /**
     * Set the linear gradient direction to be from top to bottom.
     * 
     * @return $this
     */
    public function toBottom(): static
    {
        return $this->x(0)->x2(0)->y(0)->y2(1);
    }

    /**
     * Set the linear gradient direction to be from left to right.
     * 
     * @return $this
     */
    public function toRight(): static
    {
        return $this->x(0)->x2(1)->y(0)->y2(0);
    }

    /**
     * Set the linear gradient direction to be from right to left.
     * 
     * @return $this
     */
    public function toLeft(): static
    {
        return $this->x(1)->x2(0)->y(0)->y2(0);
    }

    /**
     * Set the linear gradient direction to be from top left to bottom right.
     * 
     * @return $this
     */
    public function toBottomRight(): static
    {
        return $this->x(0)->x2(1)->y(0)->y2(1);
    }

    /**
     * Set the linear gradient direction to be from top right to bottom left.
     * 
     * @return $this
     */
    public function toTopLeft(): static
    {
        return $this->x(1)->x2(0)->y(1)->y2(0);
    }

    /**
     * Set the linear gradient direction to be from bottom left to top right.
     * 
     * @return $this
     */
    public function toTopRight(): static
    {
        return $this->x(0)->x2(1)->y(1)->y2(0);
    }

    /**
     * Set the linear gradient direction to be from bottom right to top left.
     * 
     * @return $this
     */
    public function toBottomLeft(): static
    {
        return $this->x(1)->x2(0)->y(1)->y2(0);
    }

    /**
     * Set the radial gradient center to be the center of the chart.
     * 
     * @return $this
     */
    public function center(): static
    {
        return $this->x(0.5)->y(0.5);//->r(0.5);
    }

    /**
     * Get the gradient as an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            'type' => $this->getType(),
            'x' => $this->getX(),
            'y' => $this->getY(),
            'colorStops' => $this->colorStopsToArray(),
            ...$this->isLinear() ? [
                'x2' => $this->getX2(),
                'y2' => $this->getY2(),
            ] : [],
            ...$this->isRadial() ? [
                'r' => 0.5,
            ] : [],
        ];
    }

    /**
     * Throw an exception if the value is outside the allowed range.
     * 
     * @throws \InvalidArgumentException
     */
    protected function invalidRange(string $coordinate): never
    {
        throw new \InvalidArgumentException(
            "{$coordinate} must be between 0 and 1."
        );
    }
}