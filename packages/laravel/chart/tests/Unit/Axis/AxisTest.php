<?php

declare(strict_types=1);

use Honed\Chart\Axis\Axis;

beforeEach(function () {

})->only();

it('makes axis', function () {
    dd(Axis::make()->toArray());
});