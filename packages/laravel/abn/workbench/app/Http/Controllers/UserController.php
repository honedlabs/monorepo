<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use App\Enums\Layout;
use App\Models\Alert;
use App\Actions\Alert\EditAlert;
use App\Actions\Alert\IndexAlert;
use App\Actions\Alert\StoreAlert;
use App\Actions\Alert\CreateAlert;
use App\Actions\Alert\DeleteAlert;
use App\Actions\Alert\UpdateAlert;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Modules\Breadcrumb\Breadcrumb;
use App\Http\Requests\Alert\StoreRequest;
use App\Http\Requests\Alert\UpdateRequest;
use App\Modules\Breadcrumb\BreadcrumbData;
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
