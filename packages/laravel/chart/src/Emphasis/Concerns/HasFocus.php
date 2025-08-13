<?php

declare(strict_types=1);

namespace Honed\Chart\Emphasis\Concerns;

use Honed\Chart\Enums\Focus;

/**
 * @internal
 */
trait HasFocus
{
    /**
     * When the data is highlighted, whether to fade out of other data to focus the highlighted
     *
     * @var string|null
     */
    protected $focus;

    /**
     * Set the focus highlight.
     *
     * @return $this
     */
    public function focus(string|Focus $value): static
    {
        $this->focus = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the focus highlight to none.
     *
     * @return $this
     */
    public function focusNone(): static
    {
        return $this->focus(Focus::None);
    }

    /**
     * Set the focus highlight to self.
     *
     * @return $this
     */
    public function focusSelf(): static
    {
        return $this->focus(Focus::Self);
    }

    /**
     * Set the focus highlight to series.
     *
     * @return $this
     */
    public function focusSeries(): static
    {
        return $this->focus(Focus::Series);
    }

    /**
     * Get the focus highlight.
     */
    public function getFocus(): ?string
    {
        return $this->focus;
    }
}
