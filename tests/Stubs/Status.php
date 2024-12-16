<?php

declare(strict_types=1);

namespace Honed\Crumb\Tests\Stubs;

enum Status: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case COMING_SOON = 'coming-soon';
}
