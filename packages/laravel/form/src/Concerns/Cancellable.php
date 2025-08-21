<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Enums\Cancel;

trait Cancellable
{
    /**
     * The action to take when the form is cancelled.
     *
     * @var string|null
     */
    protected $cancel;

    public function getCancel(): ?string
    {
        return $this->cancel;
    }

    /**
     * Set the action to take when the form is cancelled.
     *
     * @return $this
     */
    public function onCancel(string|Cancel $value): static
    {
        $this->cancel = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the action to take when the form is cancelled to be a redirect.
     *
     * @return $this
     */
    public function onCancelRedirect(string $url): static
    {
        return $this->onCancel($url);
    }

    /**
     * Set the action to take when the form is cancelled to be a route redirect.
     *
     * @return $this
     */
    public function onCancelRoute(string $name, mixed $parameters = []): static
    {
        return $this->onCancelRedirect(route($name, $parameters));
    }

    /**
     * Set the action to take when the form is cancelled to be a reset.
     *
     * @return $this
     */
    public function onCancelReset(): static
    {
        return $this->onCancel(Cancel::Reset);
    }
}
