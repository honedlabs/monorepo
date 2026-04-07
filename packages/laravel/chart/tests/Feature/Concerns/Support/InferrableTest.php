<?php

declare(strict_types=1);

use Honed\Chart\Chart;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can infer', function () {
    expect($this->chart)
        ->infers()->toBeFalse()
        ->infer()->toBe($this->chart)
        ->infers()->toBeTrue()
        ->dontinfer()->toBe($this->chart)
        ->infers()->toBeFalse();
});
