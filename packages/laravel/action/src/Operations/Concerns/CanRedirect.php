<?php

declare(strict_types=1);

namespace Honed\Action\Operations\Concerns;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

trait CanRedirect
{
    /**
     * The redirect for when the operation is executed.
     *
     * @var string|(Closure(mixed...):\Illuminate\Http\RedirectResponse)|null
     */
    protected string|Closure|null $redirect = null;

    /**
     * Set the redirect for when the operation is executed.
     *
     * @param  string|(Closure(mixed...):\Illuminate\Http\RedirectResponse)|null  $redirect
     * @return $this
     */
    public function redirect(string|Closure|null $redirect): static
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * Get the redirect for when the operation is executed.
     *
     * @return string|(Closure(mixed...):\Illuminate\Http\RedirectResponse)|null
     */
    public function getRedirect(): string|Closure|null
    {
        return $this->redirect;
    }

    /**
     * Determine if the operation has a redirect.
     */
    public function hasRedirect(): bool
    {
        return isset($this->redirect);
    }

    /**
     * Call the redirect for when the operation is executed.
     */
    public function callRedirect(): RedirectResponse
    {
        $redirect = $this->getRedirect();

        /** @var \Illuminate\Http\RedirectResponse */
        return match (true) {
            ! $redirect => back(),
            $redirect instanceof Closure => $this->evaluate($redirect),
            Str::startsWith($redirect, ['http://', 'https://', '/']) => redirect($redirect),
            default => to_route($redirect)
        };
    }
}
