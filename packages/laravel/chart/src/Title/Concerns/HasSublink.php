<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

trait HasSublink
{
    /**
     * The hyper link of the subtext.
     *
     * @var string|null
     */
    protected $sublink;

    /**
     * Set the hyper link of the subtext.
     */
    public function sublink(string $value): static
    {
        $this->sublink = $value;

        return $this;
    }

    /**
     * Get the hyper link of the subtext.
     */
    public function getSublink(): ?string
    {
        return $this->sublink;
    }
}
