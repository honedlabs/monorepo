<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

use function Orchestra\Testbench\workbench_path;

it('caches', function () {
    $this->artisan('binding:cache')->assertSuccessful();
});