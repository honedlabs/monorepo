<?php

declare(strict_types=1);

use Honed\Chart\Enums\Cap;
use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has cap', function () {
    expect($this->lineStyle)
        ->getCap()->toBeNull()
        ->butt()->toBe($this->lineStyle)
        ->getCap()->toBe(Cap::Butt->value)
        ->cap(Cap::Round)->toBe($this->lineStyle)
        ->getCap()->toBe(Cap::Round->value);
});
