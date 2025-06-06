<?php

declare(strict_types=1);
use App\Models\User;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->path = base_path('bootstrap/cache/binders.php');

    File::delete($this->path);
});

it('caches', function () {
    $this->artisan('bind:cache')->assertSuccessful();

    $this->assertFileExists($this->path);

    $content = require $this->path;

    expect($content)
        ->toBeArray()
        ->toHaveKey(User::class)
        ->{User::class}->scoped(fn ($bindings) => $bindings
        ->toHaveKeys([
            'admin',
            'default',
            'edit',
            'auth',
        ])->toBeArray());
});

it('has table', function () {
    $this->artisan('bind:cache', ['--table' => true])->assertSuccessful();
});
