<?php

declare(strict_types=1);

namespace Honed\Chart\Emphasis\Concerns;

use Honed\Chart\Enums\BlurScope;

trait HasBlurScope
{
    /**
     * The range of fade out when focus is enabled.
     *
     * @var string|null
     */
    protected $blurScope;

    /**
     * Set the blur scope.
     *
     * @return $this
     */
    public function blurScope(string|BlurScope $value): static
    {
        $this->blurScope = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the blur scope to coordinate system.
     *
     * @return $this
     */
    public function blurScopeCoordinateSystem(): static
    {
        return $this->blurScope(BlurScope::CoordinateSystem);
    }

    /**
     * Set the blur scope to series.
     *
     * @return $this
     */
    public function blurScopeSeries(): static
    {
        return $this->blurScope(BlurScope::Series);
    }

    /**
     * Set the blur scope to global.
     *
     * @return $this
     */
    public function blurScopeGlobal(): static
    {
        return $this->blurScope(BlurScope::Global);
    }

    /**
     * Get the blur scope.
     */
    public function getBlurScope(): ?string
    {
        return $this->blurScope;
    }
}
