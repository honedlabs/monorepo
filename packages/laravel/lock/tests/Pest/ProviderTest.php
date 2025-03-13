<?php

declare(strict_types=1);

use Honed\Lock\LockServiceProvider;

it('publishes config', function () {
    $this->artisan('vendor:publish', ['--provider' => LockServiceProvider::class])
        ->assertSuccessful();

    expect(file_exists(base_path('config/lock.php')))->toBeTrue();
});


