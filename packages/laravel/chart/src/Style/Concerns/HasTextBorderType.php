<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\BorderType;

trait HasTextBorderType
{
    /**
     * The stroke line type of the text border.
     * 
     * @var string|null
     */
    protected $textBorderType;

    /**
     * Set the stroke line type of the text border.
     * 
     * @return $this
     */
    public function textBorderType(string|BorderType $value): static
    {
        $this->textBorderType = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the stroke line type of the text border to be solid.
     * 
     * @return $this
     */
    public function textBorderSolid(): static
    {
        return $this->textBorderType(BorderType::Solid);
    }

    /**
     * Set the stroke line type of the text border to be dashed.
     * 
     * @return $this
     */
    public function textBorderDashed(): static
    {
        return $this->textBorderType(BorderType::Dashed);
    }

    /**
     * Set the stroke line type of the text border to be dotted.
     * 
     * @return $this
     */
    public function textBorderDotted(): static
    {
        return $this->textBorderType(BorderType::Dotted);
    }

    /**
     * Get the stroke line type of the text border.
     */
    public function getTextBorderType(): ?string
    {
        return $this->textBorderType;
    }
}