<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasFormat
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForFormat;
    }

    /**
     * @var string|\Closure
     */
    protected $format;

    /**
     * Get or set the format for the instance.
     * 
     * @param string|\Closure|null $format The format to set, or null to retrieve the current format.
     * @return string|null|$this The current format when no argument is provided, or the instance when setting the format.
     */
    public function format($format = null)
    {
        if (\is_null($format)) {
            return $this->format;
        }

        $this->format = $format;

        return $this;
    }

    /**
     * Determine if the instance has an format set.
     * 
     * @return bool True if an format is set, false otherwise.
     */
    public function hasFormat()
    {
        return ! \is_null($this->format);
    }

    /**
     * Evaluate the format using injected named and typed parameters, or from a model.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the format, or the model to evaluate the format from.
     * @param array<string,mixed> $typed The typed parameters to inject into the format, if provided.
     * @return string|null The evaluated format.
     */
    public function evaluateFormat($namedOrModel = [], $typed = [])
    {
        $evaluated = match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateFormatFromModel($namedOrModel),
            default => $this->evaluate($this->format, $namedOrModel, $typed)
        };

        $this->format = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the format from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the format from.
     * @return string|null The evaluated format.
     */
    private function evaluateFormatFromModel($model)
    {
        return $this->evaluateModelForFormat($model, 'evaluateFormat');
    }
}

