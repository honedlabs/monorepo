<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Columns\Column;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Honed\Table\Contracts\ShouldRemember;
use Honed\Table\Contracts\ShouldToggle;

trait IsToggleable
{
    use Support\HasDuration;

    /**
     * Whether the table should allow the user to toggle which columns are 
     * displayed.
     *
     * @var bool|null
     */
    protected $toggleable;

    /**
     * The query parameter for which columns to display.
     *
     * @var string|null
     */
    protected $columnsKey;

    /**
     * Whether the table should remember the columns to display.
     *
     * @var bool|null
     */
    protected $remember;

    /**
     * The name of the cookie to use for remembering the columns to display.
     *
     * @var string|null
     */
    protected $cookieName;

    /**
     * Set the query parameter for which columns to display.
     *
     * @return $this
     */
    public function columnsKey(string $columnsKey): static
    {
        $this->columnsKey = $columnsKey;

        return $this;
    }

    /**
     * Determine whether the table should allow the user to toggle which columns
     * are visible.
     * 
     * @return bool
     */
    public function isToggleable()
    {
        if (isset($this->toggle)) {
            return $this->toggle;
        }

        if ($this instanceof ShouldToggle) {
            return true;
        }

        return $this->getFallbackToggles();
    }

    /**
     * Get the query parameter for which columns to display.
     * 
     * @return string
     */
    public function getColumnsKey()
    {
        if (isset($this->columnsKey)) {
            return $this->columnsKey;
        }

        return $this->getFallbackColumnsKey();
    }

    /**
     * Determine whether the table should remember the user preferences.
     * 
     * @return bool
     */
    public function remembers()
    {
        if (isset($this->remember)) {
            return $this->remember;
        }

        if ($this instanceof ShouldRemember) {
            return true;
        }

        return $this->getFallbackRemembers();
    }

    /**
     * Get the cookie name to use for the table toggle.
     * 
     * @return string
     */
    public function getCookieName()
    {
        if (isset($this->cookieName)) {
            return $this->cookieName;
        }

        return $this->guessCookieName();
    }

    /**
     * Determine whether the table should allow the user to toggle which columns
     * are visible.
     *  
     * @return bool
     */
    protected function getFallbackToggles()
    {
        return (bool) config('table.toggle.enabled', false);
    }

    /**
     * Get the fallback value for the query parameter for which columns to 
     * display.
     * 
     * @return string
     */
    protected function getFallbackColumnsKey()
    {
        return type(config('table.config.columns', 'columns'))->asString();
    }



    /**
     * Guess the name of the cookie to use for remembering the columns to
     * display.
     * 
     * @return string
     */
    public function guessCookieName()
    {
        return str(static::class)
            ->classBasename()
            ->append('Table')
            ->kebab()
            ->lower()
            ->toString();
    }

    /**
     * Toggle the columns that are displayed.
     *
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return array<int,\Honed\Table\Columns\Column>
     */
    public function toggleColumns($columns)
    {
        if (! $this->isToggleable()) {
            return $columns;
        }

        $params = $this->getArrayFromQueryParameter($this->getColumnsKey());

        if ($this->remembers()) {
            $params = $this->configureCookie($params);
        }

        return \array_values(
            \array_filter(
                $columns,
                fn (Column $column) => $column
                    ->active($column->isDisplayed($params))
                    ->isActive()
            )
        );
    }

    /**
     * Use the columns cookie to determine which columns are active, or set the
     * cookie to the current columns.
     *
     * @param  array<int,string>|null  $params
     * @return array<int,string>|null
     */
    public function configureCookie($params)
    {

        // If there are params, overwrite the cookie
        if (filled($params)) {
            $this->queueCookie($params);
            // Cookie::queue(
            //     $this->getCookie(),
            //     \json_encode($params),
            //     $this->getDuration()
            // );

            return $params;
        }

        // return $this->checkCookie($request, $params);

        $value = $request->cookie($this->getCookie(), '');

        if (! \is_string($value)) {
            return $params;
        }

        /** @var array<int,string>|null */
        return \json_decode($value, false);
    }

    /**
     * Retrieve the columns to display from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<int,string>|null
     */
    public function getColumnsFromRequest($request)
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
