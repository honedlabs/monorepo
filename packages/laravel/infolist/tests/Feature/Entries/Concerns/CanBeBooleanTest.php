<?php

declare(strict_types=1);

use Honed\Infolist\Entries\BooleanEntry;

beforeEach(function () {
    $this->entry = BooleanEntry::make('is_active');
});

it('has true text', function () {
    expect($this->entry)
        ->getTrueText()->toBeNull()
        ->trueText('Yes')->toBe($this->entry)
        ->getTrueText()->toBe('Yes')
        ->format(true)->toBe('Yes')
        ->format(false)->toBeNull();
});

it('has false text', function () {
    expect($this->entry)
        ->getFalseText()->toBeNull()
        ->falseText('No')->toBe($this->entry)
        ->getFalseText()->toBe('No')
        ->format(true)->toBeNull()
        ->format(false)->toBe('No');
});
