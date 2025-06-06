<?php

declare(strict_types=1);

namespace App\Binders;

use App\Models\User;
use Honed\Bind\Attributes\Binds;
use Honed\Bind\Binder;

#[Binds(User::class)]
class AdminBinder extends Binder
{
    /**
     * Retrieve the route model binding.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function admin($query, $value)
    {
        return $query
            ->where('name', $value);
    }
}
