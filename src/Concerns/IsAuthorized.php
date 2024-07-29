<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Adds the ability to provide conditions to include classes
 */
trait IsAuthorized
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
    public function isAuthorized(): bool
    {
        return (bool) $this->evaluate($this->authorized);
    }

    /**
     * Assess whether the class is authorized.
     */
    public function isNotAuthorized(): bool
    {
        return ! $this->isAuthorized();
    }

    // RoW spelling alias

    /**
     * Alias for authorize
     */
    public function authorise(bool|Closure $condition = true): static
    {
        return $this->authorize($condition);
    }

    /**
     * Alias for authorize
     */
    public function setAuthorise(bool|Closure|null $condition = true): void
    {
        $this->setAuthorize($condition);
    }

    /**
     * Alias for authorized
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
