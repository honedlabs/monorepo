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
     * @var \Honed\Chart\Title\Title|null
     */
    protected $title;

    /**
     * Add a title.
     * 
     * @param \Honed\Chart\Title\Title|(Closure(\Honed\Chart\Title\Title):mixed)|null $value
     * @return $this
     */
    public function title(Title|Closure|null $value = null): static
    {
        return match (true) {
            is_null($value) => $this->newTitle(),
            $value instanceof Closure => $value($this->newTitle()),
            default => $this->title = $value,
        };

        return $this;
    }

    /**
     * Get the title
     * 
     * @return \Honed\Chart\Title\Title|null
     */
    public function getTitle(): ?Title
    {
        return $this->title;
    }

    /**
     * Create a new title, or use the existing one.
     */
    protected function newTitle(): Title
    {
        return $this->title ??= Title::make();
    }
}