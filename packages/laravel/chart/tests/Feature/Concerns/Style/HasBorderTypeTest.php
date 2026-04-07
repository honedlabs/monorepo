<?php

declare(strict_types=1);

use Honed\Chart\Enums\BorderType;
use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has border type', function () {
    expect($this->lineStyle)
        ->getBorderType()->toBeNull()
        ->dashed()->toBe($this->lineStyle)
        ->getBorderType()->toBe(BorderType::Dashed->value)
        ->borderType(BorderType::Solid)->toBe($this->lineStyle)
        ->getBorderType()->toBe(BorderType::Solid->value);
});
