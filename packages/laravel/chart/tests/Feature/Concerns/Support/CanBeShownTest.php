<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('can be shown', function () {
    expect($this->title)
        ->isShown()->toBeNull()
        ->show()->toBe($this->title)
        ->isShown()->toBeTrue()
        ->dontShow()->toBe($this->title)
        ->isShown()->toBeFalse();
});
