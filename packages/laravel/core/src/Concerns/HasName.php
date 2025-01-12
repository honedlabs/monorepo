<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForName;
    }

    /**
     * @var string|\Closure|null
     */
    protected $name;

    /**
     * Set the name for the instance.
     *
     * @param  string|\Closure|null  $name
     * @return $this
     */
    public function name($name): static
    {
        if (! \is_null($name)) {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Get the name for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getName($parameters = [], $typed = []): ?string
    {
        /**
         * @var string|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForName($parameters, 'getName')
            : $this->evaluate($this->name, $parameters, $typed);

        $this->name = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a name set.
     */
    public function hasName(): bool
    {
        return isset($this->name);
    }

    /**
     * Convert a string to the name format
     */
    public function makeName(?string $label): ?string
    {
        if (\is_null($label)) {
            return null;
        }

        return str($label)
            ->snake()
            ->lower()
            ->toString();
    }
}
