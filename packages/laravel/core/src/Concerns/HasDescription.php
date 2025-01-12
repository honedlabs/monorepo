<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDescription
{
    use EvaluatesClosures {
        evaluateModelForTrait as evaluateModelForDescription;
    }

    /**
     * @var string|\Closure|null
     */
    protected $description;

    /**
     * Set the description for the instance.
     *
     * @param  string|\Closure|null  $description
     * @return $this
     */
    public function description($description): static
    {
        if (! \is_null($description)) {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * Get the description for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getDescription($parameters = [], $typed = []): ?string
    {
        /**
         * @var string|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForDescription($parameters, 'getDescription')
            : $this->evaluate($this->description, $parameters, $typed);

        $this->description = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a description set.
     */
    public function hasDescription(): bool
    {
        return isset($this->description);
    }
}
