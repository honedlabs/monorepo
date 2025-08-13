<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait Draggable
{
    /**
     * Whether to allow the user to adjust the position by dragging.
     */
    protected bool $draggable = false;

    /**
     * Set whether to allow the user to adjust the position by dragging.
     *
     * @return $this
     */
    public function draggable(bool $value = true): static
    {
        $this->draggable = $value;

        return $this;
    }

    /**
     * Set whether to not allow the user to adjust the position by dragging.
     *
     * @return $this
     */
    public function notDraggable(bool $value = true): static
    {
        return $this->draggable(! $value);
    }

    /**
     * Get whether to allow the user to adjust the position by dragging.
     */
    public function isDraggable(): bool
    {
        return $this->draggable;
    }

    /**
     * Get whether to not allow the user to adjust the position by dragging.
     */
    public function isNotDraggable(): bool
    {
        return ! $this->isDraggable();
    }
}
