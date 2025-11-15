<?php

declare(strict_types=1);

namespace Honed\Scaffold\Properties;

class TimestampProperty
{
    /**
     * Whether the property is unsigned.
     * 
     * @var bool
     */
    protected $unsigned = false;

    /**
     * The number of bytes.
     */
    protected $size;
}