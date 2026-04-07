<?php

declare(strict_types=1);

use Honed\Chart\Legend;

beforeEach(function () {
    $this->legend = Legend::make();
});

it('has empty array representation by default', function () {
    expect($this->legend->toArray())->toEqual([]);
});

it('has labels', function () {
    $names = ['A', 'B', 'C'];

    expect($this->legend)
        ->getLabels()->toBeNull()
        ->labels($names)->toBe($this->legend)
        ->getLabels()->toEqual($names);

    expect($this->legend->toArray()['data'])->toEqual($names);
});

it('serializes layout and inactive legend options', function () {
    $this->legend
        ->id('legend-main')
        ->show()
        ->scroll()
        ->zlevel(1)
        ->z(10)
        ->left('5%')
        ->top(20)
        ->right('10%')
        ->bottom('8%')
        ->width(200)
        ->height(80)
        ->padding([8, 12])
        ->inactiveColor('#888')
        ->inactiveBorderColor('#444')
        ->inactiveWidth(0);

    expect($this->legend->toArray())->toEqual([
        'type' => 'scroll',
        'id' => 'legend-main',
        'show' => true,
        'zlevel' => 1,
        'z' => 10,
        'left' => '5%',
        'top' => 20,
        'right' => '10%',
        'bottom' => '8%',
        'width' => 200,
        'height' => 80,
        'padding' => [8, 12],
        'inactiveColor' => '#888',
        'inactiveBorderColor' => '#444',
        'inactiveBorderWidth' => 0,
    ]);
});
