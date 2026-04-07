<?php

declare(strict_types=1);

use Honed\Chart\Label;

beforeEach(function () {
    $this->label = Label::make();
});

it('has border width', function () {
    expect($this->label)
        ->getBorderWidth()->toBeNull()
        ->borderWidth(2)->toBe($this->label)
        ->getBorderWidth()->toBe(2);
});
