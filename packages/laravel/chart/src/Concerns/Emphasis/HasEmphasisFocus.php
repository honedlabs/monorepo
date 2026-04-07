<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Emphasis;

use Honed\Chart\Enums\Focus;
use TypeError;
use ValueError;

trait HasEmphasisFocus
{
    /**
     * Focus strategy when this element is highlighted.
     *
     * @var Focus|null
     */
    protected $emphasisFocus;

    /**
     * Set the focus strategy for the emphasis state.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function focus(string|Focus $value): static
    {
        $this->emphasisFocus = is_string($value) ? Focus::from($value) : $value;

        return $this;
    }

    /**
     * Get the emphasis focus strategy.
     */
    public function getEmphasisFocus(): ?Focus
    {
        return $this->emphasisFocus;
    }
}
