<?php

declare(strict_types=1);

namespace Honed\Action\Concerns\Support;

trait HasDismissMessage
{
    /**
     * The message to display on the dismiss button.
     * 
     * @var string
     */
    protected $dismiss = 'Cancel';

    /**
     * Set the dismiss message for the confirm.
     *
     * @return $this
     */
    public function dismiss(?string $dismiss): static
    {
        if (! \is_null($dismiss)) {
            $this->dismiss = $dismiss;
        }

        return $this;
    }

    /**
     * Get the dismiss message for the confirm.
     */
    public function getDismiss(): string
    {
        return $this->dismiss;
    }    
}
