<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Form;
use Illuminate\Database\Eloquent\Model;

trait BelongsToForm
{
    /**
     * The form instance.
     *
     * @var ?Form
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
     *
     * @return array<string, mixed>|Model|null
     */
    public function getRecord(): array|Model|null
    {
        return $this->getForm()?->getRecord();
    }
}
