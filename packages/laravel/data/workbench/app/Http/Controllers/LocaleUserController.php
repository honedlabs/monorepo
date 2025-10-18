<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Locale;
use App\Models\User;
use Illuminate\Routing\Controller;

class LocaleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Locale $locale)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Locale $locale)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Locale $locale) {
    }

    /**
     * Display the specified resource.
     */
    public function show(Locale $locale, User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Locale $locale, User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Locale $locale, User $user )
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locale $locale, User $user)
    {
    }
}
