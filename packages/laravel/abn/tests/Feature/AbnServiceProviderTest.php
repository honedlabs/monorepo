<?php

declare(strict_types=1);

use Honed\Abn\AbnServiceProvider;
use Honed\Abn\Rules\Abn;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

beforeEach(function () {
    File::cleanDirectory(resource_path('lang/vendor'));
});

it('registers macros', function () {
    expect(Rule::abn())
        ->toBeInstanceOf(Abn::class);
});

it('publishes translations', function () {
    $this->artisan('vendor:publish', [
        '--provider' => AbnServiceProvider::class,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('lang/vendor/abn/en/messages.php'));
});
