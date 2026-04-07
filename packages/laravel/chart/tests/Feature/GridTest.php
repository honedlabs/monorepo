<?php

declare(strict_types=1);

use Honed\Chart\Grid;

beforeEach(function () {
    $this->grid = Grid::make();
});

it('has layout representation', function () {
    expect($this->grid)
        ->getLeft()->toBeNull()
        ->left('3%')->toBe($this->grid)
        ->getLeft()->toBe('3%')
        ->right('4%')->toBe($this->grid)
        ->getRight()->toBe('4%')
        ->bottom('5%')->toBe($this->grid)
        ->getBottom()->toBe('5%')
        ->containLabel()->toBe($this->grid)
        ->getContainLabel()->toBeTrue()
        ->toArray()->toEqual([
            'left' => '3%',
            'right' => '4%',
            'bottom' => '5%',
            'containLabel' => true,
        ]);
});
