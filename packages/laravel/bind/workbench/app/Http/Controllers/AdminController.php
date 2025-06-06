<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function admin(User $user)
    {
        return $user;
    }
}
