<?php

declare(strict_types=1);

namespace App\Binders;

use App\Models\User;
use Honed\Bind\Binder;

class AuthenticatableBinder extends Binder
{
    /**
     * {@inheritdoc}
     */
    protected $model = User::class;

    /**
     * {@inheritdoc}
     */
    protected $key = 'id';

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
        return $query->select('email');
    }
}
