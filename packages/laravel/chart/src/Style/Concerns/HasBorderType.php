<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\BorderType;

trait HasBorderType
{
    /**
     * The stroke line type of the border.
     * 
     * @var string|int|array<int, int>|null
     */
    protected $borderType;

    /**
     * Set the stroke line type of the border.
     * 
     * @param string|int|array<int, int>|BorderType $value
     * @return $this
     */
    public function borderType(string|int|array|BorderType $value): static
    {
        $this->borderType = $value instanceof BorderType ? $value->value : $value;

        return $this;
    }

    /**
     * Set the stroke line type of the border to be solid.
     * 
     * @return $this
     */
    public function solid(): static
    {
        return $this->borderType(BorderType::Solid);
    }

    /**
     * Set the stroke line type of the border to be dashed.
     * 
     * @return $this
     */
    public function dashed(): static
    {
        return $this->borderType(BorderType::Dashed);
    }

    /**
     * Set the stroke line type of the border to be dotted.
     * 
     * @return $this
     */
    public function dotted(): static
    {
        return $this->borderType(BorderType::Dotted);
    }

    /**
     * Get the stroke line type of the border.
     * 
     * @return string|int|array<int, int>|null
     */
    public function getBorderType(): string|int|array|null
    {
        return $this->borderType;
    }
}