<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Str;

trait HasLabel
{
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
    public function label($label)
    {
        if (! \is_null($label)) {
            $this->label = $label;
        }

        return $this;
    }

    /**
     * Get the label for the instance.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label instanceof \Closure
            ? $this->resolveLabel()
            : $this->label;
    }

    /**
     * Evaluate the label for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function resolveLabel(array $parameters = [], array $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->label, $parameters, $typed);

        $this->label = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a label set.
     *
     * @return bool
     */
    public function hasLabel()
    {
        return ! \is_null($this->label);
    }

    /**
     * Convert a string to the label format.
     *
     * @param  string|null  $name
     * @return string|null
     */
    public static function makeLabel($name)
    {
        if (\is_null($name)) {
            return null;
        }

        return Str::of($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
