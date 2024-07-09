<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Adds the ability to provide conditions to include classes
 */
trait CanAuthorize
{
    protected bool|Closure $authorized = true;

    /**
     * Set the condition for authorization, chainable.
     */
    public function authorize(bool|Closure $condition = true): static
    {
        $this->setAuthorize($condition);

        return $this;
    }

    /**
     * Alias for authorize
     */
    public function authorise(bool|Closure $condition = true): static
    {
        return $this->authorize($condition);
    }

    /**
     * Set the condition for authorization quietly.
     */
    public function setAuthorize(bool|Closure|null $condition): void
    {
        if (is_null($condition)) {
            return;
        }
        $this->authorized = $condition;
    }

    /**
     * Assess whether the class is authorized.
     */
    public function authorized(): bool
    {
        return $this->evaluate($this->authorized);
    }

    /**
     * Alias for authorized
     */
    public function isAuthorized(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     */
    public function authorised(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     */
    public function isAuthorised(): bool
    {
        return $this->authorized();
    }

    /**
     * Assess whether the class is not authorized
     */
    public function notAuthorized(): bool
    {
        return ! $this->authorized();
    }

    /**
     * Alias for notAuthorized
     */
    public function isNotAuthorized(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     */
    public function notAuthorised(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     */
    public function isNotAuthorised(): bool
    {
        return $this->notAuthorized();
    }
}
