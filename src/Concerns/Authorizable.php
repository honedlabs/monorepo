<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait Authorizable
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected bool|\Closure $authorized = true;

    /**
     * Set the condition for authorization, chainable.
     * 
     * @param bool|\Closure():bool $condition
     * @return $this
     */
    public function authorize(bool|\Closure $condition = true): static
    {
        $this->setAuthorize($condition);

        return $this;
    }

    /**
     * Alias for authorize
     * 
     * @param bool|\Closure():bool $condition
     * @return $this
     */
    public function authorise(bool|\Closure $condition = true): static
    {
        return $this->authorize($condition);
    }

    /**
     * Set the condition for authorization quietly.
     * 
     * @param bool|\Closure():bool|null $condition
     */
    public function setAuthorize(bool|\Closure|null $condition): void
    {
        if (is_null($condition)) {
            return;
        }
        $this->authorized = $condition;
    }

    /**
     * Alias for setAuthorize
     * 
     * @param bool|\Closure():bool|null $condition
     */
    public function setAuthorise(bool|\Closure|null $condition): void
    {
        $this->setAuthorize($condition);
    }

    /**
     * Determine if the class is authorized.
     */
    public function isAuthorized(): bool
    {
        return (bool) $this->evaluate($this->authorized);
    }

    /**
     * Determine if the class is not authorized.
     */
    public function isNotAuthorized(): bool
    {
        return ! $this->isAuthorized();
    }

    /**
     * Alias for isAuthorized
     */
    public function isAuthorised(): bool
    {
        return $this->isAuthorized();
    }

    /**
     * Alias for isNotAuthorized
     */
    public function isNotAuthorised(): bool
    {
        return ! $this->isAuthorised();
    }    
}
