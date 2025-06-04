<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->path = base_path('bootstrap/cache/binders.php');

    File::delete($this->path);
});

it('caches', function () {
    $this->artisan('bind:cache')->assertSuccessful();

    $this->assertFileExists($this->path);
});
