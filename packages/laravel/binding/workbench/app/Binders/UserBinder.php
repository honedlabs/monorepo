<?php

namespace App\Binders;

use Honed\Binding\Binder;

class UserBinder extends Binder
{
    /**
     * Retrieve the route model binding for the show method.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function show($query, $value)
    {
        return $query->select('id', 'name');
    }

    /**
     * Retrieve the route model binding for the edit method.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function edit($query, $value)
    {
        return $query->select('name', 'email');
    }

}