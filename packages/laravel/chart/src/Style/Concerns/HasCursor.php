<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Enums\Cursor;

trait HasCursor
{
    /**
     * The mouse style.
     * 
     * @var string|null
     */
    protected $cursor;

    /**
     * Set the mouse style.
     * 
     * @return $this
     */
    public function cursor(string|Cursor $value): static
    {
        $this->cursor = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Get the mouse style.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }
}