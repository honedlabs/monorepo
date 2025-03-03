<?php

declare(strict_types=1);

use Inertia\ResponseFactory;
use Honed\Flash\Support\Parameters;
use Honed\Flash\FlashServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

it('publishes config', function () {
    $this->artisan('vendor:publish', ['--provider' => FlashServiceProvider::class])
        ->assertSuccessful();

    expect(file_exists(base_path('config/flash.php')))->toBeTrue();
});

it('has redirect response macros', function () {
    expect(back()->flash('Hello World'))
        ->toBeInstanceOf(RedirectResponse::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'Hello World',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});

it('has inertia response macros', function () {
    expect(inertia()->flash('Hello World'))
        ->toBeInstanceOf(ResponseFactory::class);

    expect(Session::get(Parameters::PROP))
        ->toEqual([
            'message' => 'Hello World',
            'type' => config('flash.type'),
            'title' => null,
            'duration' => config('flash.duration'),
            'meta' => [],
        ]);
});


