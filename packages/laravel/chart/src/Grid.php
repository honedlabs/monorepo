<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Proxies\HigherOrderTooltip;

class Grid extends Chartable
{
    use HasId;
    use HasTooltip;
    use Proxyable;

    protected ?string $left = null;

    protected ?string $right = null;

    protected ?string $bottom = null;

    protected ?bool $containLabel = null;

    /**
     * Get a property of the grid.
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'tooltip' => new HigherOrderTooltip($this, $this->withTooltip()),
            default => $this->defaultGet($name),
        };
    }

    public function left(?string $value): static
    {
        $this->left = $value;

        return $this;
    }

    public function getLeft(): ?string
    {
        return $this->left;
    }

    public function right(?string $value): static
    {
        $this->right = $value;

        return $this;
    }

    public function getRight(): ?string
    {
        return $this->right;
    }

    public function bottom(?string $value): static
    {
        $this->bottom = $value;

        return $this;
    }

    public function getBottom(): ?string
    {
        return $this->bottom;
    }

    public function containLabel(bool $value = true): static
    {
        $this->containLabel = $value;

        return $this;
    }

    public function getContainLabel(): ?bool
    {
        return $this->containLabel;
    }

    /**
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'left' => $this->getLeft(),
            'right' => $this->getRight(),
            'bottom' => $this->getBottom(),
            'containLabel' => $this->getContainLabel(),
        ];
    }
}
