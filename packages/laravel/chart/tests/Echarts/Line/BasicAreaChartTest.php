<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Line\Line;

beforeEach(function () {
    $this->series = [820, 932, 901, 934, 1290, 1330, 1320];

    $this->x = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    $this->option = [
        'xAxis' => [
            [
                'type' => 'category',
                'boundaryGap' => false,
                'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            ]
        ],
        'yAxis' => [
            [
                'type' => 'value'
            ]
        ],
        'series' => [
            [
                'type' => 'line',
                'areaStyle' => [],
                'data' => [820, 932, 901, 934, 1290, 1330, 1320],
            ]
        ]
    ];
})->only();

it('creates', function () {
    $chart = Chart::make()
        ->axis(
            XAxis::make()
                ->category()
                ->boundaryGap(false)
                ->values($this->x)
        )
        ->series([
            Line::make()
                ->areaStyle()
                ->values($this->series)
        ]);

    expect($chart->toArray())
        ->dd()
        ->toEqualCanonicalizing($this->option);    
});