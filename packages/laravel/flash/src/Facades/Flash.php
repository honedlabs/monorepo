<?php

declare(strict_types=1);

namespace Honed\Flash\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Flash\FlashFactory
 *
 * @method static \Honed\Flash\FlashFactory message(string|\Honed\Flash\Message $message, string|null $type = null, string|null $title = null, int|null $duration = null, array<string,mixed> $meta = []) Flash a new message to the session.
 * @method static \Honed\Flash\FlashFactory success(string $message, string|null $title = null, int|null $duration = null, array<string,mixed> $meta = []) Flash a new success message to the session.
 * @method static \Honed\Flash\FlashFactory error(string $message, string|null $title = null, int|null $duration = null, array<string,mixed> $meta = []) Flash a new error message to the session.
 * @method static \Honed\Flash\FlashFactory info(string $message, string|null $title = null, int|null $duration = null, array<string,mixed> $meta = []) Flash a new info message to the session.
 * @method static \Honed\Flash\FlashFactory warning(string $message, string|null $title = null, int|null $duration = null, array<string,mixed> $meta = []) Flash a new warning message to the session.
 */
class Flash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Flash\FlashFactory::class;
    }
}
