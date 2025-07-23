<?php

declare(strict_types=1);

namespace Honed\Billing;

final class Payment
{
    public const RECURRING = 'recurring';

    public const ONCE = 'once';

    /**
     * Get the valid types of payment.
     *
     * @return array<int, string|null>
     */
    public static function values(): array
    {
        return [
            null,
            'null',
            self::RECURRING,
            self::ONCE,
        ];
    }
}
