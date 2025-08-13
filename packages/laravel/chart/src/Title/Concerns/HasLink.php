<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

trait HasLink
{
    /**
     * The hyper link of the main text.
     *
     * @var string|null
     */
    protected $link;

    /**
     * Set the hyper link of the main text.
     */
    public function link(string $value): static
    {
        $this->link = $value;

        return $this;
    }

    /**
     * Get the hyper link of the main text.
     */
    public function getLink(): ?string
    {
        return $this->link;
    }
}
