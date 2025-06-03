<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Workbench\App\Http\Requests\UserStoreRequest;
use Workbench\App\Models\User;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        User::factory()->create($request->validated());

        return back();
    }
}
