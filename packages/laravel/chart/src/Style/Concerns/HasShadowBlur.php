<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasShadowBlur
{
    /**
     * The size of the shadow blur.
     *
     * @var int|null
     */
    protected $shadowBlur;

    /**
     * Set the size of the shadow blur.
     *
     * @return $this
     */
    public function shadowBlur(int $value): static
    {
        $this->shadowBlur = $value;

        return $this;
    }

    /**
     * Get the size of the shadow blur.
     */
    public function getShadowBlur(): ?int
    {
        return $this->shadowBlur;
    }
}
