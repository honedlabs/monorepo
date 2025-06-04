<?php

namespace App\Binders;

use App\Models\User;
use Honed\Binding\Binder;

class AuthenticatableBinder extends Binder
{
    /**
     * {@inheritdoc}
     */
    protected $model = User::class;

    /**
     * Retrieve the route model binding.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function auth($query, $value)
    {
        return $query->where('id', '>', 10);
    }
}