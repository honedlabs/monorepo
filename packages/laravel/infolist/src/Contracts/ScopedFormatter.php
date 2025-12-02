<?php

declare(strict_types=1);

namespace Honed\Infolist\Contracts;

/**
 * @template TFormatter of \Honed\Infolist\Contracts\Formatter
 */
interface ScopedFormatter
{
    /**
     * Scope a custom formatter for this instance.
     *
     * @param  TFormatter  $formatter
     * @return TFormatter
     */
    public function scopeFormatter(Formatter $formatter): Formatter;
}
