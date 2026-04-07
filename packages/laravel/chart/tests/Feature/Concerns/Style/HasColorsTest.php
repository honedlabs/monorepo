<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Style\Rgb;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have colors', function () {
    expect($this->chart)
        ->hasColors()->toBeFalse()
        ->color('#111')->toBe($this->chart)
        ->hasColors()->toBeTrue()
        ->getColors()->count()->toBe(1)
        ->colour('#222')->toBe($this->chart)
        ->getColors()->count()->toBe(2);
});

it('can merge colors from an array', function () {
    $this->chart->colors(['#a', '#b', '#c']);

    expect($this->chart->getColors()->count())->toBe(3);
    expect($this->chart->listColors())->toBe(['#a', '#b', '#c']);
});

it('can merge colors from an enumerable', function () {
    $this->chart->colors(collect(['#f00', Rgb::make(0, 128, 255)]));

    expect($this->chart->getColors()->count())->toBe(2);
    expect($this->chart->listColors())->toBe(['#f00', 'rgb(0, 128, 255)']);
});

it('can merge a single color via colors()', function () {
    $this->chart->colors('#999');

    expect($this->chart->getColors()->all())->toBe(['#999']);
});

it('aliases colours to colors for bulk merge', function () {
    $this->chart->colours(['#1', '#2']);

    expect($this->chart->listColors())->toBe(['#1', '#2']);
});

it('includes list colors in chart representation', function () {
    $this->chart->color('#10a')->color('#20b');

    $repr = $this->chart->toArray();

    expect($repr['color'])->toBe(['#10a', '#20b']);
});
