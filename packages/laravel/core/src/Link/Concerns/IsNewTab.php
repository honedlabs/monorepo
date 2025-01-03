<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsNewTab
{
    /**
     * @var bool
     */
    protected $newTab = false;

    /**
     * Set the url to open in a new tab, chainable.
     *
     * @return $this
     */
    public function newTab(bool $newTab = true): static
    {
        $this->setNewTab($newTab);

        return $this;
    }

    /**
     * Set the url to open in a new tab property quietly.
     */
    public function setNewTab(bool $newTab): void
    {
        $this->newTab = $newTab;
    }

    /**
     * Determine if the url should be opened in a new tab.
     */
    public function isNewTab(): bool
    {
        return $this->newTab;
    }
}
