<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workbench\App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        /** @var \Workbench\App\Models\User $user */
        $user = Auth::user();

        $user->update($request->safe());

        return back();
    }
}
