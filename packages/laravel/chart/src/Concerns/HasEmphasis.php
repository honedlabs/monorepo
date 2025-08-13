<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Emphasis\Emphasis;

trait HasEmphasis
{
    /**
     * The emphasis.
     *
     * @var Emphasis|null
     */
    protected $emphasis;

    /**
     * Add a emphasis.
     *
     * @param  Emphasis|(Closure(Emphasis):Emphasis)|null  $value
     * @return $this
     */
    public function emphasis(Emphasis|Closure|null $value = null): static
    {
        $this->emphasis = match (true) {
            is_null($value) => $this->withEmphasis(),
            $value instanceof Closure => $value($this->withEmphasis()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the emphasis
     */
    public function getEmphasis(): ?Emphasis
    {
        return $this->emphasis;
    }

    /**
     * Create a new emphasis, or use the existing one.
     */
    protected function withEmphasis(): Emphasis
    {
        return $this->emphasis ??= Emphasis::make();
    }
}
