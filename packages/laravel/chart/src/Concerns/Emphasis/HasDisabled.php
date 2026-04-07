<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Emphasis;

trait HasDisabled
{
    /**
     * When true, the emphasis layer is disabled for this series element.
     *
     * @var bool|null
     */
    protected $disabled;

    /**
     * Set whether the emphasis layer is disabled.
     *
     * @return $this
     */
    public function disabled(bool $value = true): static
    {
        $this->disabled = $value;

        return $this;
    }

    /**
     * Allow emphasis for this series element.
     *
     * @return $this
     */
    public function enableEmphasis(): static
    {
        $this->disabled = false;

        return $this;
    }

    /**
     * Whether the emphasis layer is disabled.
     */
    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }
}
