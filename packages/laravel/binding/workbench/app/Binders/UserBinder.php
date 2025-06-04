<?php

namespace Workbench\App\Binders;

use Honed\Binding\Binder;

class UserBinder extends Binder
{
    /**
     * Retrieve the route model binding.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function show($query, $value)
    {
        return $query->select('id', 'name');
    }
}