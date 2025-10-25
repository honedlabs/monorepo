<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

interface Formable
{
    /**
     * Transform the data to form data.
     *
     * @return array<string, mixed>
     */
    public function toForm(): array;
}
