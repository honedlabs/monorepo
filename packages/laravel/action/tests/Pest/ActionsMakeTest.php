<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Actions'));
});

it('makes', function () {
    $this->artisan('make:actions', [
        // 'model' => 'Product',
    ])->assertSuccessful();

    // $this->assertFileExists(app_path('Actions/TestAction.php'));
});