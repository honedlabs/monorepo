<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:contract', [
        'name' => 'ShouldAct',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Contracts/ShouldAct.php'));
});