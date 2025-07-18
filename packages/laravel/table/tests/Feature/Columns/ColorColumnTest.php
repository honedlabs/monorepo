<?php

declare(strict_types=1);

use Honed\Table\Columns\ColorColumn;
use Honed\Table\Columns\Column;

beforeEach(function () {
    $this->column = ColorColumn::make('color');
});

it('is type color', function () {
    expect($this->column)
        ->getType()->toBe(Column::COLOR);
});
