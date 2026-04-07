<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Emphasis;

use Honed\Chart\Enums\BlurScope;
use TypeError;
use ValueError;

trait HasEmphasisBlurScope
{
    /**
     * Blur scope when elements outside the focus are dimmed.
     *
     * @var BlurScope|null
     */
    protected $emphasisBlurScope;

    /**
     * Set the blur scope for the emphasis state.
     *
     * @return $this
     *
     * @throws ValueError
     * @throws TypeError
     */
    public function blurScope(string|BlurScope $value): static
    {
        $this->emphasisBlurScope = is_string($value) ? BlurScope::from($value) : $value;

        return $this;
    }

    /**
     * Get the emphasis blur scope.
     */
    public function getEmphasisBlurScope(): ?BlurScope
    {
        return $this->emphasisBlurScope;
    }
}
