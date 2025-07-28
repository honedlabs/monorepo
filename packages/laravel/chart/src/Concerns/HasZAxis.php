<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasZAxis
{
    /**
     * The z value of all graphical elements, used to control order of drawing graphical components.
     * 
     * @var int|null
     */
    protected $z;

    /**
     * The z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     * 
     * @var int|null
     */
    protected $zLevel;

    /**
     * Set the z value of all graphical elements, used to control order of drawing graphical components.
     * 
     * @return $this
     */
    public function z(?int $value): static
    {
        $this->z = $value;

        return $this;
    }

    /**
     * Get the z value of all graphical elements, used to control order of drawing graphical components.
     */
    public function getZ(): ?int
    {
        return $this->z;
    }

    /**
     * Set the z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     * 
     * @return $this
     */
    public function zLevel(?int $value): static
    {
        $this->zLevel = $value;

        return $this;
    }

    /**
     * Get the z-level used to make layers with canvas, elements with different z-level values are drawn in different canvases.
     */
    public function getZLevel(): ?int
    {
        return $this->zLevel;
    }

    /**
     * Get the z axis parameters as an array representation.
     * 
     * @return array<string, mixed>
     */
    public function getZAxisParameters(): array
    {
        return [
            'z' => $this->getZ(),
            'zLevel' => $this->getZLevel(),
        ];
    }
}