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
     * Determine whether this table has toggling of the columns enabled.
     */
    public function isToggleable(): bool
    {
        if (isset($this->toggle)) {
            return $this->toggle;
        }

        return false;
    }

    /**
     * Determine whether this table has toggling of the columns enabled.
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

        return str(static::class)
            ->classBasename()
            ->append('Table')
            ->kebab()
            ->lower()
            ->toString();
    }

    /**
     * Get the default duration of the cookie to use for the table toggle.
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
     * @return array<int,\Honed\Table\Columns\Column>
     */
    public function toggle(): array
    {
        $columns = $this->getColumns();

        if (! $this->isToggleable()) {
            return $columns;
        }

        /** @var \Illuminate\Http\Request */
        $request = $this->getRequest();

        $params = $this->getColumnsFromRequest($request);

        if ($this->isRemembering()) {
            $params = $this->configureCookie($request, $params);
        }

        return Arr::where(
            $columns,
            static fn (Column $column) => ($column->isKey() || 
                $column->isToggleable()) && (
                    \is_null($params) || 
                    \in_array($column->getName(), $params)
                )
        );
    }

    /**
     * @param array<int,string>|null $params
     * 
     * @return array<int,string>|null
     */
    public function configureCookie(Request $request, ?array $params): ?array
    {
        if (! \is_null($params)) {
            Cookie::queue(
                $this->getCookie(), 
                \json_encode($params), 
                $this->getDuration()
            );

            return $params;
        }

        $params = $request->cookie($this->getCookie(), null);

        if (\is_null($params)) {
            return null;
        }

        /** @var array<int,string> */
        return \json_decode($params, false);
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
            ->map(fn ($v) => \trim($v))
            ->toArray();
    }
}
