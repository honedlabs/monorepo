<?php

declare(strict_types=1);

use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('can have id', function () {
    expect($this->title)
        ->getId()->toBeNull()
        ->id('title')->toBe($this->title)
        ->getId()->toBe('title');
});
