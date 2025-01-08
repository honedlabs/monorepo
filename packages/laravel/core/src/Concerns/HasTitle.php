<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasTitle
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForTitle;
    }

    /**
     * @var string|\Closure|null
     */
    protected $title = null;

    /**
     * Get or set the title for the instance.
     * 
     * @param string|\Closure|null $title The title to set, or null to retrieve the current title.
     * @return string|null|$this The current title when no argument is provided, or the instance when setting the title.
     */
    public function title($title = null)
    {
        if (\is_null($title)) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Determine if the instance has an title set.
     * 
     * @return bool True if an title is set, false otherwise.
     */
    public function hasTitle()
    {
        return ! \is_null($this->title);
    }

    /**
     * Evaluate the title using injected named and typed parameters, or from a model.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $namedOrModel The named parameters to inject into the title, or the model to evaluate the title from.
     * @param array<string,mixed> $typed The typed parameters to inject into the title, if provided.
     * @return string|null The evaluated title.
     */
    public function evaluateTitle($namedOrModel = [], $typed = [])
    {
        $evaluated = match (true) {
            $namedOrModel instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateTitleFromModel($namedOrModel),
            default => $this->evaluate($this->title, $namedOrModel, $typed)
        };

        $this->title = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the title from a model.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to evaluate the title from.
     * @return string|null The evaluated title.
     */
    private function evaluateTitleFromModel($model)
    {
        return $this->evaluateModelForTitle($model, 'evaluateTitle');
    }
}

