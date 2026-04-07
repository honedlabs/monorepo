<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has color', function () {
    expect($this->textStyle)
        ->getColor()->toBeNull()
        ->color('#111')->toBe($this->textStyle)
        ->getColor()->toBe('#111')
        ->colour('#222')->toBe($this->textStyle)
        ->getColour()->toBe('#222');
});
