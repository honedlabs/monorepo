<?php

use Conquest\Chart\Series\Line\Line;

it('can test', function () {
    dd(Line::make()->shaded()->emphasis()->toArray());
});
