<?php

use Honed\Nav\Navigation;

it('has a `nav` helper', function () {
    expect(nav())->toBeInstanceOf(Navigation::class);
});
