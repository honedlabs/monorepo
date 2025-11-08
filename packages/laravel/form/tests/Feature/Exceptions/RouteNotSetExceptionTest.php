<?php

declare(strict_types=1);

use Honed\Form\Exceptions\RouteNotSetException;

it('throws exception', function () {
    RouteNotSetException::throw();
})->throws(RouteNotSetException::class);
