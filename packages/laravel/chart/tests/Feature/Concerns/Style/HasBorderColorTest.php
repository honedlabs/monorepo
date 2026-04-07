<?php

declare(strict_types=1);

use Honed\Chart\Label;

beforeEach(function () {
    $this->label = Label::make();
});

it('has border color', function () {
    expect($this->label)
        ->getBorderColor()->toBeNull()
        ->borderColor('#333')->toBe($this->label)
        ->getBorderColor()->toBe('#333');
});
