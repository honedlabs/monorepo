<?php

use Honed\Crumb\Manager;

it('has a `crumbs` helper', function () {
    expect(crumbs())->toBeInstanceOf(Manager::class);
});
