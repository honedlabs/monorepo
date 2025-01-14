<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasExtra
{
    use EvaluatesClosures {
        evaluateModelForTrait as evaluateModelForExtra;
    }

    /**
     * @var array<string,mixed>|\Closure
     */
    protected $extra = [];

    /**
     * Set the extra for the instance.
     *
     * @param  string|\Closure|null  $extra
     * @return $this
     */
    public function extra($extra): static
    {
        if (! \is_null($extra)) {
            $this->extra = $extra;
        }

        return $this;
    }

    /**
     * Get the extra for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     * @return array<string,mixed>|null
     */
    public function getExtra($parameters = [], $typed = []): ?array
    {
        /**
         * @var array<string,mixed>|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForExtra($parameters, 'getExtra')
            : $this->evaluate($this->extra, $parameters, $typed);

        $this->extra = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a extra set.
     */
    public function hasExtra(): bool
    {
        return $this->extra instanceof \Closure || \count($this->extra) > 0;
    }
}
