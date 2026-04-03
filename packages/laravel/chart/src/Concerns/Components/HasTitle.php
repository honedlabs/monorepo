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
    protected $title;

    /**
     * Add a title.
     *
     * @param  Title|(Closure(Title):Title)|string|bool|null  $value
     * @return $this
     */
    public function title(Title|Closure|string|bool|null $value = true): static
    {
        $this->title = match (true) {
            $value => $this->withTitle(),
            ! $value => null,
            is_string($value) => $this->withTitle()->text($value),
            $value instanceof Closure => $value($this->withTitle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the title
     */
    public function getTitle(): ?Title
    {
        return $this->title;
    }

    /**
     * Create a new title, or use the existing one.
     */
    protected function withTitle(): Title
    {
        return $this->title ??= Title::make();
    }
}
