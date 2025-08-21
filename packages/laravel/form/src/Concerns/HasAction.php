<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait HasAction
{
    /**
     * The action of the form.
     *
     * @var string|null
     */
    protected $action;

    /**
     * Set the action of the form.
     *
     * @return $this
     */
    public function action(string $value): static
    {
        $this->action = $value;

        return $this;
    }

    /**
     * Get the action of the form.
     */
    public function getAction(): ?string
    {
        return $this->action;
    }
}
