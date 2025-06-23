<?php

declare(strict_types=1);

use Honed\Table\Columns\KeyColumn;
use Honed\Table\Columns\Column;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->column = KeyColumn::make('id');
});

it('is key', function () {
    expect($this->column)
        ->getType()->toBeNull()
        ->isKey()->toBeTrue()
        ->isHidden()->toBeTrue()
        ->isQualifying()->toBeTrue();
});