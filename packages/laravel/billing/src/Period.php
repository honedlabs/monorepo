<?php

declare(strict_types=1);

namespace Honed\Billing;

final class Period
{
    public const DAILY = 'daily';

    public const WEEKLY = 'weekly';

    public const MONTHLY = 'monthly';

    public const QUARTERLY = 'quarterly';

    public const YEARLY = 'yearly';

    /**
     * Get the valid periods.
     *
     * @return array<int, string|null>
     */
    public static function values(): array
    {
        return [
            null,
            'null',
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY,
            self::QUARTERLY,
            self::YEARLY,
        ];
    }
}
