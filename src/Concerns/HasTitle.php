<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a title property on a class
 */
trait HasTitle
{
    protected string|Closure|null $title = null;

    /**
     * Set the title, chainable.
     */
    public function title(string|Closure $title): static
    {
        $this->setTitle($title);

        return $this;
    }

    /**
     * Set the title quietly.
     */
    public function setTitle(string|Closure|null $title): void
    {
        if (is_null($title)) return;
        $this->title = $title;
    }

    /**
     * Get the title
     *
     * @return string|Closure
     */
    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    /**
     * Check if the class has a title
     */
    public function hasTitle(): bool
    {
        return ! is_null($this->getTitle());
    }

    /**
     * Check if the class lacks a title
     */
    public function lacksTitle(): bool
    {
        return ! $this->hasTitle();
    }
}
