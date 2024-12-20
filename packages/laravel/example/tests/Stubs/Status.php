<?php

declare(strict_types=1);

namespace VendorName\PackageName\Tests\Stubs;

enum Status: string
{
    case Available = 'available';
    case Unavailable = 'unavailable';
    case ComingSoon = 'coming-soon';
}
