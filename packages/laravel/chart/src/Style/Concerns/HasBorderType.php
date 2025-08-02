<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\BorderType;

trait HasBorderType
{
    /**
     * The stroke line type of the border.
     * 
     * @var string|null
     */
    protected $borderType;

    /**
     * Set the stroke line type of the border.
     * 
     * @return $this
     */
    public function borderType(string|BorderType $value): static
    {
        $this->borderType = is_string($value) ? $value : $value->value;

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
     */
    public function getBorderType(): ?string
    {
        return $this->borderType;
    }
}