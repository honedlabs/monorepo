<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Line\Line;

beforeEach(function () {
    $this->series = [150, 230, 224, 218, 135, 147, 260];

    $this->x = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    $this->option = [
        'xAxis' => [
            [
                'type' => 'category',
                'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            ],
        ],
        'yAxis' => [
            [
                'type' => 'value',
            ],
        ],
        'series' => [
            [
                'type' => 'line',
                'data' => [150, 230, 224, 218, 135, 147, 260],
            ],
        ],
    ];
})->only();

it('creates', function () {
    $chart = Chart::make()
        ->axis(
            XAxis::make()
                ->category()
                ->values($this->x)
        )
        ->series(Line::make()->values($this->series));

    expect($chart->toArray())
        ->toEqualCanonicalizing($this->option);
});
