<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExampleController
{
    public function user(Request $request, User $user)
    {
        return Inertia::render('Users/Show', ['user' => $user, 'page' => $request->input('page')]);
    }

    public function product(User $user, Product $product)
    {
        return Inertia::modal('Products/Show', [
            'user' => $user,
            'product' => $product,
        ])
            ->baseRoute('users.show', $user);
    }

    public function differentParameters(User $user, Product $product)
    {
        return Inertia::modal('Products/Show', [
            'user' => $user,
            'product' => $product,
        ])
            ->baseRoute('users.show', User::where('id', '<>', $user->id)->first());
    }

    public function rawUser(string $user)
    {
        return Inertia::render('Users/Show', ['user' => $user]);
    }

    public function rawProduct($user, $product)
    {
        return Inertia::modal('Products/Show', [
            'user' => $user,
            'product' => $product,
        ])
            ->baseRoute('raw.users.show', $user);
    }
}
