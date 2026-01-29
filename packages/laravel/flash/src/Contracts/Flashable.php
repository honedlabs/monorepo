<?php

declare(strict_types=1);

namespace Honed\Flash\Contracts;

use Honed\Flash\Enums\FlashType;

interface Flashable
{
    /**
     * Set the message content.
     *
     * @return $this
     */
    public function message(?string $message): static;

    /**
     * Set the type of the message.
     *
     * @return $this
     */
    public function type(string|FlashType|null $type): static;

    /**
     * Set the duration of the message.
     *
     * @return $this
     */
    public function duration(?int $duration): static;

    /**
     * Get the array representation of the message.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array;
}
