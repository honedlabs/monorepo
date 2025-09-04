<?php

declare(strict_types=1);

namespace Honed\Disable\Contracts;

interface Disableable
{
    public function isDisabled(): bool;

    public function disable(bool $value = true): void;
}