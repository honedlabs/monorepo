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
    protected $title;

    /**
     * Set the title for the instance.
     *
     * @param  string|\Closure|null  $title
     * @return $this
     */
    public function title($title): static
    {
        if (! \is_null($title)) {
            $this->title = $title;
        }

        return $this;
    }

    /**
     * Get the title for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getTitle($parameters = [], $typed = []): ?string
    {
        /**
         * @var string|null
         */
        $evaluated = $parameters instanceof \Illuminate\Database\Eloquent\Model
            ? $this->evaluateModelForTitle($parameters, 'getTitle')
            : $this->evaluate($this->title, $parameters, $typed);

        $this->title = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a title set.
     */
    public function hasTitle(): bool
    {
        return isset($this->title);
    }
}
