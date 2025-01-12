<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasLabel
{
    use EvaluatesClosures {
        evaluateModelForTrait as evaluateModelForLabel;
    }

    /**
     * @var string|\Closure|null
     */
    protected $label;

    /**
     * Set the label for the instance.
     *
     * @param  string|\Closure|null  $label
     * @return $this
     */
    public function label($label): static
    {
        if (! \is_null($label)) {
            $this->label = $label;
        }

        return $this;
    }

    /**
     * Get the label for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getLabel($parameters = [], $typed = []): ?string
    {
        /**
         * @var string|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForLabel($parameters, 'getLabel')
            : $this->evaluate($this->label, $parameters, $typed);

        $this->label = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a label set.
     */
    public function hasLabel(): bool
    {
        return isset($this->label);
    }

    /**
     * Convert a string to the label format.
     */
    public function makeLabel(?string $name): ?string
    {
        if (\is_null($name)) {
            return null;
        } 

        return str($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
