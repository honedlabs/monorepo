<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTitle
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $title = null;

    /**
     * Set the title, chainable.
     *
     * @param  string|\Closure(mixed...)  $title
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
     * @param  string|(\Closure(mixed...):string)|null  $title
     */
    public function setTitle(string|\Closure|null $title): void
    {
        if (is_null($title)) {
            return;
        }
        $this->title = $title;
    }

    /**
     * Get the title using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getTitle(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->title, $named, $typed);
    }

    /**
     * Resolve the title using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveTitle(array $named = [], array $typed = []): ?string
    {
        $this->setTitle($this->getTitle($named, $typed));

        return $this->title;
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
