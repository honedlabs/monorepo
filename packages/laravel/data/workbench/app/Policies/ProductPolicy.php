<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Product $product): bool
    {
        return $product->user()->is($user);
    }

    public function create(User $user): bool
    {
        return true;
    }
}
