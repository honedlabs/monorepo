<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasMeta
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForMeta;
    }

    /**
     * @var array<string,mixed>|\Closure
     */
    protected $meta = [];

    /**
     * Get or set the meta for the instance.
     *
     * @param  array<string,mixed>|\Closure|null  $meta
     * @return $this
     */
    public function meta($meta = null): static
    {
        if (! \is_null($meta)) {
            $this->meta = $meta;
        }

        return $this;
    }

    /**
     * Get the meta for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function getMeta($parameters = [], $typed = []): array
    {
        /**
         * @var array<string,mixed>
         */
        $evaluated = (array) ($parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForMeta($parameters, 'getMeta')
            : $this->evaluate($this->meta, $parameters, $typed));

        $this->meta = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has meta set.
     */
    public function hasMeta(): bool
    {
        return $this->meta instanceof \Closure || \count($this->meta) > 0;
    }
}
