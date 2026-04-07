<?php

declare(strict_types=1);

use Honed\Chart\AreaStyle;
use Honed\Chart\Enums\Origin;

beforeEach(function () {
    $this->areaStyle = AreaStyle::make();
});

it('has origin', function () {
    expect($this->areaStyle)
        ->getOrigin()->toBeNull()
        ->originAuto()->toBe($this->areaStyle)
        ->getOrigin()->toBe(Origin::Auto->value)
        ->origin(Origin::End)->toBe($this->areaStyle)
        ->getOrigin()->toBe(Origin::End->value);
});
