<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasLabel
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForLabel;
    }

    /**
     * @var string|\Closure|null
     */
    protected $label = null;

    /**
     * Get or set the label for the instance.
     * 
     * @param string|\Closure|null $label The label to set, or null to retrieve the current label.
     * @return string|null|$this The current label when no argument is provided, or the instance when setting the label.
     */
    public function label($label = null)
    {
        if (\is_null($label)) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    /**
     * Determine if the instance has an label set.
     * 
     * @return bool True if an label is set, false otherwise.
     */
    public function hasLabel()
    {
        return ! \is_null($this->label);
    }

    /**
     * Evaluate the label using injected named and typed parameters, or from a model.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the label, or the model to evaluate the label from.
     * @param array<string,mixed> $typed The typed parameters to inject into the label, if provided.
     * @return string|null The evaluated label.
     */
    public function evaluateLabel($namedOrModel = [], $typed = [])
    {
        $evaluated = match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateLabelFromModel($namedOrModel),
            default => $this->evaluate($this->label, $namedOrModel, $typed)
        };

        $this->label = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the label from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the label from.
     * @return string|null The evaluated label.
     */
    private function evaluateLabelFromModel($model)
    {
        return $this->evaluateModelForLabel($model, 'evaluateLabel');
    }

    /**
     * Convert a string to the label format.
     *
     * @param  string  $name
     * @return string
     */
    public function makeLabel($name)
    {
        return str($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->value();
    }
}
