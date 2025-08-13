<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Title\Title;

trait HasTitle
{
    /**
     * The title.
     *
     * @var Title|null
     */
    protected $title;

    /**
     * Add a title.
     *
     * @param  Title|(Closure(Title):Title)|null  $value
     * @return $this
     */
    public function title(Title|Closure|null $value = null): static
    {
        $this->title = match (true) {
            is_null($value) => $this->withTitle(),
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
