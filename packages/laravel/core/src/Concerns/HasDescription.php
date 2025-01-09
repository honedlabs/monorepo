<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDescription
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForDescription;
    }

    /**
     * @var string|\Closure
     */
    protected $description;

    /**
     * Get or set the description for the instance.
     * 
     * @param string|\Closure|null $description The description to set, or null to retrieve the current description.
     * @return string|null|$this The current description when no argument is provided, or the instance when setting the description.
     */
    public function description($description = null)
    {
        if (\is_null($description)) {
            return $this->description;
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Determine if the instance has an description set.
     * 
     * @return bool True if an description is set, false otherwise.
     */
    public function hasDescription()
    {
        return ! \is_null($this->description);
    }

    /**
     * Evaluate the description using injected named and typed parameters, or from a model.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the description, or the model to evaluate the description from.
     * @param array<string,mixed> $typed The typed parameters to inject into the description, if provided.
     * @return string|null The evaluated description.
     */
    public function evaluateDescription($namedOrModel = [], $typed = [])
    {
        $evaluated = match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateDescriptionFromModel($namedOrModel),
            default => $this->evaluate($this->description, $namedOrModel, $typed)
        };

        $this->description = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the description from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the description from.
     * @return string|null The evaluated description.
     */
    private function evaluateDescriptionFromModel($model)
    {
        return $this->evaluateModelForDescription($model, 'evaluateDescription');
    }
}

