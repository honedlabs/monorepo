<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->path = base_path('bootstrap/cache/binders.php');

    File::put($this->path, '<?php return [];');
});

it('caches', function () {
    $this->assertFileExists($this->path);

    $this->artisan('bind:clear')->assertSuccessful();

    $this->assertFileDoesNotExist($this->path);
});
