<?php

declare(strict_types=1);

namespace Honed\Action;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Handler
{
    /**
     * @var \Illuminate\Contracts\Database\Eloquent\Builder
     */
    protected $resource;

    /**
     * @param \Illuminate\Contracts\Database\Eloquent\Builder $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function handle($request)
    {

    }
}