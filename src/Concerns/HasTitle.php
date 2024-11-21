<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTitle
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $title = null;

    /**
     * Set the title, chainable.
     * 
     * @param string|\Closure():string $title
     * @return $this
     */
    public function title(string|\Closure $title): static
    {
        $this->setTitle($title);

        return $this;
    }

    /**
     * Set the title quietly.
     * 
     * @param string|(\Closure():string)|null $title
     */
    public function setTitle(string|\Closure|null $title): void
    {
        if (is_null($title)) {
            return;
        }
        $this->title = $title;
    }

    /**
     * Get the title
     */
    public function getTitle(): ?string
    {
        return $this->evaluate($this->title);
    }

    /**
     * Determine if the class does not have a title.
     */
    public function missingTitle(): bool
    {
        return \is_null($this->title);
    }

    /**
     * Determine if the class has a title.
     */
    public function hasTitle(): bool
    {
        return ! $this->missingTitle();
    }
}
