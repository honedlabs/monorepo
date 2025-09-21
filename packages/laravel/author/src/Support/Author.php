<?php

declare(strict_types=1);

namespace Honed\Author\Support;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

final class Author
{
    /**
     * The custom callback to get the authoring identifier.
     *
     * @return (Closure(): int|string|null)|null
     */
    protected static ?Closure $callback = null;

    /**
     * Set the custom callback to get the authoring identifier.
     */
    public static function using(?Closure $callback): void
    {
        self::$callback = $callback;
    }

    /**
     * Get the authoring model.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static function model(): string
    {
        /** @var class-string<\Illuminate\Database\Eloquent\Model> */
        return config('author.model', User::class);
    }

    /**
     * Get the authoring identifier.
     *
     * @return int|string|null
     */
    public static function identifier(): mixed
    {
        $callback = self::$callback;

        if (! is_null($callback)) {
            return $callback();
        }

        return Auth::id();
    }
}
