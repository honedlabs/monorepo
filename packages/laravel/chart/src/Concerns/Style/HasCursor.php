<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Style;

use Honed\Chart\Enums\Cursor;

trait HasCursor
{
    /**
     * The mouse style.
     *
     * @var ?Cursor
     */
    protected $cursor;

    /**
     * Set the mouse style.
     *
     * @return $this
     */
    public function cursor(string|Cursor $value): static
    {
        $this->cursor = is_string($value) ? Cursor::from($value) : $value;

        return $this;
    }

    /**
     * Set the mouse style to be default.
     *
     * @return $this
     */
    public function cursorDefault(): static
    {
        return $this->cursor(Cursor::Default);
    }

    /**
     * Set the mouse style to be pointer.
     *
     * @return $this
     */
    public function cursorPointer(): static
    {
        return $this->cursor(Cursor::Pointer);
    }

    /**
     * Get the mouse style.
     */
    public function getCursor(): ?Cursor
    {
        return $this->cursor;
    }
}
