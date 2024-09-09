<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;
use Conquest\Core\Attributes\Title;
use ReflectionClass;

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
        if (is_null($title)) {
            return;
        }
        $this->title = $title;
    }

    /**
     * Get the title
     *
     * @return string|Closure
     */
    public function getTitle(): ?string
    {
        return $this->evaluate($this->title) ?? $this->evaluateTitleAttribute();
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

    /**
     * Evaluate the title attribute if present
     */
    protected function evaluateTitleAttribute(): ?string
    {
        $attributes = (new ReflectionClass($this))->getAttributes(Title::class);

        if (! empty($attributes)) {
            return $attributes[0]->newInstance()->getTitle();
        }

        return null;
    }
}
