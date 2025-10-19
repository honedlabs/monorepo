<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    /**
     * Display the specified resource.
     */
    public function show(User $user) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) {}
}
