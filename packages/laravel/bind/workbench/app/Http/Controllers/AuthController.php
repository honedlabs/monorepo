<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function auth(User $user)
    {
        return $user;
    }
}
