<?php

declare(strict_types=1);

use Honed\Infolist\Entries\NumericEntry;
use Honed\Infolist\Formatters\NumericFormatter;

beforeEach(function () {
    $this->entry = NumericEntry::make('age');
});

it('is set up', function () {
    expect($this->entry)
        ->getType()->toBe('numeric')
        ->defaultFormatter()->toBeInstanceOf(NumericFormatter::class);
});
