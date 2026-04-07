<?php

declare(strict_types=1);

use Honed\Chart\Label;

beforeEach(function () {
    $this->label = Label::make();
});

it('has border radius', function () {
    expect($this->label)
        ->getBorderRadius()->toBeNull()
        ->borderRadius(6)->toBe($this->label)
        ->getBorderRadius()->toBe(6);
});
