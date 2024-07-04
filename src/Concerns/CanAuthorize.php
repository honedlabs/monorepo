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
     * 
     * @param bool|\Closure $condition
     * @return static
     */
    public function authorize(bool|Closure $condition = true): static
    {
        $this->setAuthorize($condition);
        return $this;
    }

    /**
     * Set the condition for authorization quietly.
     * 
     * @param bool|Closure $condition
     * @return void
     */
    public function setAuthorize(bool|Closure|null $condition): void
    {
        if (is_null($condition)) return;
        $this->authorized = $condition;
    }
    /**
     * Assess whether the class is authorized.
     * 
     * @return bool
     */
    public function authorized(): bool
    {
        return $this->evaluate($this->authorized);
    }

    /**
     * Alias for authorized
     * 
     * @return bool
     */
    public function allowed(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     * 
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     * 
     * @return bool
     */
    public function isAllowed(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     * 
     * @return bool
     */
    public function authorised(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorized
     * 
     * @return bool
     */
    public function isAuthorised(): bool
    {
        return $this->authorized();
    }

    /**
     * Alias for authorize
     * 
     * @param bool|Closure $condition
     * @return static
     */
    public function authorise(bool|Closure $condition = true): static
    {
        return $this->authorize($condition);
    }

    /**
     * Assess whether the class is not authorized
     * 
     * @return bool
     */
    public function notAuthorized(): bool
    {
        return !$this->authorized();
    }

    /**
     * Aias for notAuthorized
     * 
     * @return bool
     */
    public function notAllowed(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     * 
     * @return bool
     */
    public function isNotAuthorized(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     * 
     * @return bool
     */
    public function isNotAllowed(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     * 
     * @return bool
     */
    public function notAuthorised(): bool
    {
        return $this->notAuthorized();
    }

    /**
     * Alias for notAuthorized
     * 
     * @return bool
     */
    public function isNotAuthorised(): bool
    {
        return $this->notAuthorized();
    }
}