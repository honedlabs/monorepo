<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasBorderType
{
    protected ?string $borderType = null;

    public const BORDER_TYPES = [
        'solid',
        'dashed',
        'dotted',
    ];

    public function borderType(string $borderType): self
    {
        $this->setBorderType($borderType);

        return $this;
    }

    public function setBorderType(?string $borderType): void
    {
        if (is_null($borderType)) {
            return;
        }
        if (! in_array($borderType, self::BORDER_TYPES)) {
            throw new \Exception("Invalid borderType given {$borderType} does not match valid borderTypes.");
        }

        $this->borderType = $borderType;
    }

    public function getBorderType(): ?string
    {
        return $this->borderType;
    }

    public function lacksBorderType(): bool
    {
        return is_null($this->borderType);
    }

    public function hasBorderType(): bool
    {
        return ! $this->lacksBorderType();
    }

    public function getBorderTypeOption(): array
    {
        return $this->hasBorderType() ? [
            'borderType' => $this->getBorderType(),
        ] : [];

    }
}
