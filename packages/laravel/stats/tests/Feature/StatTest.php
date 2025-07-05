<?php

declare(strict_types=1);

use Honed\Stats\Stat;

beforeEach(function () {
    $this->stat = Stat::make('name');
});

it('has name and label', function () {
    expect($this->stat)
        ->getName()->toBe('name')
        ->getLabel()->toBe('Name');

    expect(Stat::make('name', 'Label'))
        ->getName()->toBe('name')
        ->getLabel()->toBe('Label');
});

it('can have a group', function () {
    expect($this->stat)
        ->getGroup()->toBeNull()
        ->group()->toBe($this->stat)
        ->getGroup()->toBeNull()
        ->group('group')->toBe($this->stat)
        ->getGroup()->toBe('group');
});
