<?php

declare(strict_types=1);

use Honed\Disable\Support\Disable;

it('retrieves boolean config value', function () {
    expect(Disable::boolean())->toBeTrue();

    config(['disable.boolean' => false]);

    expect(Disable::boolean())->toBeFalse();
});

it('retrieves timestamp config value', function () {
    expect(Disable::timestamp())->toBeTrue();

    config(['disable.timestamp' => false]);

    expect(Disable::timestamp())->toBeFalse();
});

it('retrieves user config value', function () {
    expect(Disable::user())->toBeTrue();

    config(['disable.user' => false]);

    expect(Disable::user())->toBeFalse();
});