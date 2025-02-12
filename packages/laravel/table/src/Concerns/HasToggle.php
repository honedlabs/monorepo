<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Honed\Table\Columns\Column;
use Illuminate\Support\Collection;
use Honed\Table\Columns\BaseColumn;
use Illuminate\Support\Facades\Cookie;
use Honed\Table\Contracts\ShouldRemember;

trait HasToggle
{
    const Duration = 60 * 24 * 30 * 365; // 1 year

    const ColumnsKey = 'columns';

    /**
     * @var bool|null
     */
    protected $toggle;

    /**
     * @var bool|null
     */
    protected $remember;

    /**
     * @var string|null
     */
    protected $cookie;

    /**
     * @var int|null
     */
    protected $duration;

    /**
     * @var string|null
     */
    protected $columnsKey;
    
    /**
     * @var bool|null
     */
    protected $orderable;

    /**
     * Determine whether this table allows for the user to toggle which
     * columns are visible.
     */
    public function isToggleable(): bool
    {
        if (isset($this->toggle)) {
            return $this->toggle;
        }

        return false;
    }

    /**
     * Determine whether the user's preferences should be remembered.
     */
    public function isRemembering(): bool
    {
        if (isset($this->remember)) {
            return $this->remember;
        }

        if ($this instanceof ShouldRemember) {
            return true;
        }

        return false;
    }

    /**
     * Get the cookie name to use for the table toggle.
     */
    public function getCookie(): string
    {
        if (isset($this->cookie)) {
            return $this->cookie;
        }

        return $this->guessCookieName();
    }

    /**
     * Guess the name of the cookie to use for the table toggle.
     */
    public function guessCookieName(): string
    {
        return str(static::class)
            ->classBasename()
            ->append('Table')
            ->kebab()
            ->lower()
            ->toString();
    }

    /**
     * Get the duration of the cookie to use for how long the table should.
     * remember the user's preferences.
     */
    public function getDuration(): int
    {
        if (isset($this->duration)) {
            return $this->duration;
        }

        return self::Duration;
    }

    /**
     * Get the query parameter to use for toggling columns.
     */
    public function getColumnsKey(): string
    {
        if (isset($this->columnsKey)) {
            return $this->columnsKey;
        }

        return self::ColumnsKey;
    }

    /**
     * Determine whether the user can order the columns.
     */
    public function isOrderable(): bool
    {
        if (isset($this->orderable)) {
            return $this->orderable;
        }

        return false;
    }

    /**
     * Toggle the columns that are visible.
     * 
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * 
     * @return array<int,\Honed\Table\Columns\Column>
     */
    public function toggle(array $columns): array
    {
        if (! $this->isToggleable()) {
            return $columns;
        }

        /** @var \Illuminate\Http\Request */
        $request = $this->getRequest();

        $params = $this->getColumnsFromRequest($request);

        if ($this->isRemembering()) {
            $params = $this->useColumnsCookie($request, $params);
        }

        // Get the columns which are active
        return Arr::where(
            $columns,
            static fn (Column $column) => $column->active(
                    $column->isDisplayed($params)
                )->isActive()
        );
    }

    /**
     * Use the columns cookie to determine which columns are active, or set the
     * cookie to the current columns.
     * 
     * @param array<int,string>|null $params
     * 
     * @return array<int,string>|null
     */
    public function useColumnsCookie(Request $request, ?array $params): ?array
    {
        // If there are params, overwrite the current cookie
        if (! \is_null($params)) {
            Cookie::queue(
                $this->getCookie(), 
                $params, 
                $this->getDuration()
            );

            return $params;
        }

        /** @var array<int,string>|null */
        $params = $request->cookie($this->getCookie(), null);

        if (\is_null($params)) {
            return null;
        }

        return $params;
    }

    /**
     * Retrieve the columns to display from the request.
     * 
     * @return array<int,string>|null
     */
    public function getColumnsFromRequest(Request $request): ?array
    {
        $matches = $request->string($this->getColumnsKey(), null);

        if ($matches->isEmpty()) {
            return null;
        }

        /** @var array<int,string> */
        return $matches
            ->explode(',')
            ->map(fn ($value) => trim($value))
            ->filter()
            ->toArray();
    }
}
