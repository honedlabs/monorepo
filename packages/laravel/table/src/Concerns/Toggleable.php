<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Support\Stringable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

trait Toggleable
{
    const RememberDuration = 60 * 24 * 30 * 365; // 1 year

    const RememberName = 'cols';

    /**
     * The name of this table's cookie for remembering column visibility
     * 
     * @var string
     */
    protected $cookie;

    /**
     * Whether the table has cookies enabled.
     */
    protected $cookies;

    /**
     * Whether the table has cookies enabled by default.
     */
    protected static $withCookies = true;

    /**
     * The duration that this table's cookie should be remembered for
     * 
     * @var int|null
     */
    protected $duration;

    /**
     * The duration of the cookie to use for all tables.
     * 
     * @var int|null
     */
    protected static $cookieRemember = self::RememberDuration;

    /**
     * The name of the query parameter to use for toggling columns.
     * 
     * @var string
     */
    protected $remember;

    /**
     * The name to use for the query parameter to toggle visibility for all tables.
     * 
     * @var string
     */
    protected static $rememberName = self::RememberName;

    /**
     * Whether to enable toggling of column visibility for this table.
     * 
     * @var bool
     */
    protected $toggle;

    /**
     * Whether to enable toggling of column visibility for all tables.
     * 
     * @var bool
     */
    protected static $defaultToggle = false;

    /**
     * Configure the default duration of the cookie to use for all tables.
     */
    public static function rememberCookieFor(int|null $seconds): void
    {
        static::$cookieRemember = $seconds;
    }

    /**
     * Configure the name of the query parameter to use for toggling columns.
     */
    public static function rememberCookieAs(string $name = null): void
    {
        static::$rememberName = $name ?? self::RememberName;
    }

    /**
     * Configure whether to enable toggling of columns for all tables by default.
     */
    public static function alwaysToggleable(bool $toggle = true): void
    {
        static::$defaultToggle = $toggle;
    }

    /**
     * Configure whether to enable cookies for all tables by default.
     */
    public static function useCookies(bool $cookies = true): void
    {
        static::$withCookies = $cookies;
    }

    /**
     * Set as toggleable quietly.
     */
    public function setToggleable(bool $toggle): void
    {
        $this->toggle = $toggle;
    }

    /**
     * Get the cookie name to use for the table toggle.
     */
    public function getCookieName(): string
    {
        return \property_exists($this, 'cookie') && ! \is_null($this->cookie)
            ? $this->cookie
            : $this->getDefaultCookie();
    }

    /**
     * Determine whether the table has cookies enabled.
     */
    public function useCookie(): bool
    {
        return (bool) (\property_exists($this, 'cookies') && ! \is_null($this->cookies))
            ? $this->cookies
            : static::$withCookies;
    }

    /**
     * Get the default cookie name to use for the table.
     */
    public function getDefaultCookie(): string
    {
        return (new Stringable(static::class))
            ->classBasename()
            ->append('Table')
            ->kebab()
            ->lower()
            ->toString();
    }

    /**
     * Get the default duration of the cookie to use for the table toggle.
     */
    public function getRememberDuration(): int
    {
        return match (true) {
            ! \property_exists($this, 'duration') || \is_null($this->duration) => static::$cookieRemember,
            $this->duration > 0 => $this->duration,
            default => 5 * 365 * 24 * 60 * 60,
        };
    }

    /**
     * Get the query parameter to use for toggling columns.
     */
    public function getRememberName(): string
    {
        return \property_exists($this, 'remember') && ! \is_null($this->remember)
            ? $this->remember
            : static::$rememberName;
    }

    /**
     * Determine whether this table has toggling of the columns enabled.
     */
    public function isToggleable(): bool
    {
        return (bool) (\property_exists($this, 'toggle') && ! \is_null($this->toggle))
            ? $this->toggle
            : static::$defaultToggle;
    }

    /**
     * Update the cookie with the new data.
     */
    public function enqueueCookie(mixed $data): void
    {
        Cookie::queue(
            $this->getCookieName(), 
            \json_encode($data), 
            $this->getRememberDuration()
        );
    }

    /**
     * Get the data stored in the cookie.
     */
    public function retrieveCookie(Request $request = null): mixed
    {
        return \json_decode(
            ($request ?? request())->cookie($this->getCookieName(), null),
            true
        );
    }

    /**
     * Get the columns to show.
     *
     * @return array<int,string>
     */
    public function toggleParameters(Request $request = null): array
    {
        $request = $request ?? request();

        return $request->string($this->getRememberName())
            ->trim()
            ->remove(' ')
            ->explode(',')
            ->toArray();
    }

    /**
     * 
     */
    public function atoggleColumns(array $columns = [], Request $request = null): void
    {
        // Cookies, query parameters, or default

        

    }
}
