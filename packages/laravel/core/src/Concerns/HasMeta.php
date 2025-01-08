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
     * @param array<string,mixed>|\Closure|null $meta The meta to set, or null to retrieve the current meta.
     * @return array<string,mixed>|$this The current meta when no argument is provided, or the instance when setting the meta.
     */
    public function meta($meta = null)
    {
        if (\is_null($meta)) {
            return (array) $this->meta;
        }

        $this->meta = $meta;

        return $this;
    }

    /**
     * Determine if the instance has an meta set.
     * 
     * @return bool True if an meta is set, false otherwise.
     */
    public function hasMeta()
    {
        return ! \is_null($this->meta);
    }

    /**
     * Evaluate the meta using injected named and typed parameters, or from a model.
     * 
     * @param array<array,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the meta, or the model to evaluate the meta from.
     * @param array<array,mixed> $typed The typed parameters to inject into the meta, if provided.
     * @return array<string,mixed> The evaluated meta.
     */
    public function evaluateMeta($namedOrModel = [], $typed = [])
    {
        $evaluated = (array) match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateMetaFromModel($namedOrModel),
            default => $this->evaluate($this->meta, $namedOrModel, $typed)
        };

        $this->meta = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the meta from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the meta from.
     * @return array<string,mixed> The evaluated meta.
     */
    private function evaluateMetaFromModel($model)
    {
        return $this->evaluateModelForMeta($model, 'evaluateMeta');
    }
}

