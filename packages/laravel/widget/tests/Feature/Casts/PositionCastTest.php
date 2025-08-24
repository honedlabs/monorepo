<?php

declare(strict_types=1);

namespace Tests\Feature\Casts;

use Honed\Widget\Facades\Widgets;

beforeEach(function () {})->only();

it('tests', function () {
    dd(Widgets::convertToGridArea('a1:b2'));
});