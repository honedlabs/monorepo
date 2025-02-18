<?php

declare(strict_types=1);

namespace Honed\Action\Concerns\Support;

trait HasSubmitMessage
{
    /**
     * The message to display on the submit button.
     * 
     * @var string
     */
    protected $submit = 'Cancel';

    /**
     * Set the submit message for the confirm.
     *
     * @return $this
     */
    public function submit(?string $submit): static
    {
        if (! \is_null($submit)) {
            $this->submit = $submit;
        }

        return $this;
    }

    /**
     * Get the submit message for the confirm.
     */
    public function getSubmit(): string
    {
        return $this->submit;
    }    
}
