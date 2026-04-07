<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Title;

trait HasTitle
{
    /**
     * The title.
     *
     * @var ?Title
     */
    protected $titleInstance;

    /**
     * Add a title.
     *
     * @param  Title|(Closure(Title):Title)|string|bool|null  $value
     * @return $this
     */
    public function title(Title|Closure|string|bool|null $value = true): static
    {
        $this->titleInstance = match (true) {
            $value => $this->withTitle(),
            is_string($value) => $this->withTitle()->text($value),
            $value instanceof Closure => $value($this->withTitle()),
            $value instanceof Title => $value,
            default => null,
        };

        return $this;
    }

    /**
     * Get the title
     */
    public function getTitle(): ?Title
    {
        return $this->titleInstance;
    }

    /**
     * Create a new title, or use the existing one.
     */
    protected function withTitle(): Title
    {
        return $this->titleInstance ??= Title::make();
    }
}
