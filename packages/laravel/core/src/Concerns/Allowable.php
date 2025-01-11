<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Model;

trait Allowable
{
    use EvaluableDependency {
        evaluateModelForTrait as evaluateModelForAllowable;
    }
    
    /**
     * @var \Closure|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition for the instance.
     * 
     * @return $this
     */
    public function allow(\Closure|bool $allow): static
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Determine if the instance allows the given parameters.
     * 
     * @param array<string,mixed>|\Illuminate\Database\Eloquent\Model $parameters
     * @param array<string,mixed> $typed
     */
    public function isAllowed($parameters = [], $typed = []): bool
    {
        $evaluated = (bool) ($parameters instanceof Model 
            ? $this->evaluateModelForAllowable($parameters, 'isAllowed') 
            : $this->evaluate($this->allow, $parameters, $typed));

        $this->allow = $evaluated;

        return $evaluated;
    }
}