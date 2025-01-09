<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForName;
    }

    /**
     * @var string|\Closure
     */
    protected $name;

    /**
     * Get or set the name for the instance.
     * 
     * @param string|\Closure|null $name The name to set, or null to retrieve the current name.
     * @return string|null|$this The current name when no argument is provided, or the instance when setting the name.
     */
    public function name($name = null)
    {
        if (\is_null($name)) {
            return $this->name;
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Determine if the instance has an name set.
     * 
     * @return bool True if an name is set, false otherwise.
     */
    public function hasName()
    {
        return ! \is_null($this->name);
    }

    /**
     * Evaluate the name using injected named and typed parameters, or from a model.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the name, or the model to evaluate the name from.
     * @param array<string,mixed> $typed The typed parameters to inject into the name, if provided.
     * @return string|null The evaluated name.
     */
    public function evaluateName($namedOrModel = [], $typed = [])
    {
        $evaluated = match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateNameFromModel($namedOrModel),
            default => $this->evaluate($this->name, $namedOrModel, $typed)
        };

        $this->name = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the name from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the name from.
     * @return string|null The evaluated name.
     */
    private function evaluateNameFromModel($model)
    {
        return $this->evaluateModelForName($model, 'evaluateName');
    }

    /**
     * Convert a string to the name name.
     *
     * @param string $label
     * @return string
     */
    public function makeName($label)
    {
        return str($label)
            ->snake()
            ->lower()
            ->toString();
    }
}
