<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:builder', [
        'name' => 'ProductBuilder',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Builders/ProductBuilder.php'));
});