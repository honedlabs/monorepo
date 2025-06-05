<?php

use Honed\Bind\BindServiceProvider;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->cache = base_path('bootstrap/cache/binders.php');
    $this->stub = base_path('stubs/honed.binder.stub');

    File::delete([$this->cache, $this->stub]);
});

it('offers publishing', function () {
    $this->assertFileDoesNotExist($this->stub);

    $this->artisan('vendor:publish', [
        '--provider' => BindServiceProvider::class
    ])->assertSuccessful();

    // $this->assertFileExists($this->stub);
});

it('discovers binders', function () {

});
