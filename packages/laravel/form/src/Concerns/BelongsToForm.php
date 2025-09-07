<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Form;

trait BelongsToForm
{
    /**
     * The form instance.
     *
     * @var Form|null
     */
    protected $form;

    /**
     * Set the form instance.
     *
     * @return $this
     */
    public function form(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get the form instance.
     */
    public function getForm(): ?Form
    {
        return $this->form;
    }

    /**
     * Get the record from the form.
     */
    public function getRecord(): mixed
    {
        return $this->getForm();
    }
}
