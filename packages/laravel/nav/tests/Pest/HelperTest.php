<?php

declare(strict_types=1);

use Honed\Nav\Nav;

it('has a `nav` helper', function () {
    expect(nav())->toBeInstanceOf(Nav::class);
});
