<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Routing\Controller;

class ProductUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product) {}

    /**
     * Display the specified resource.
     */
    public function show(Product $product, User $user) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, User $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, User $user) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, User $user) {}
}
