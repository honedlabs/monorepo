<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasFormat
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForFormat;
    }

    /**
     * @var string|\Closure|null
     */
    protected $format;

    /**
     * Set the format for the instance.
     *
     * @param  string|\Closure|null  $format
     * @return $this
     */
    public function format($format): static
    {
        if (! \is_null($format)) {
            $this->format = $format;
        }

        return $this;
    }

    /**
     * Get the format for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getFormat($parameters = [], $typed = []): ?string
    {
        /**
         * @var string|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForFormat($parameters, 'getFormat')
            : $this->evaluate($this->format, $parameters, $typed);

        $this->format = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a format set.
     */
    public function hasFormat(): bool
    {
        return isset($this->format);
    }
}
