<?php

declare(strict_types=1);

use Honed\Chart\Series\Line;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->expected = [
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
                'data' => [150, 230, 224, 218, 135, 147, 260],
                'type' => 'line',
            ],
        ],
    ];

    $this->data = array_map(
        static fn (string $day, int $value): array => ['day' => $day, 'value' => $value],
        Arr::get($this->expected, 'xAxis.0.data'),
        Arr::get($this->expected, 'series.0.data')
    );
});

it('is replicable', function () {
    $chart = Line::make()
        ->from($this->data)
        ->infer()
        ->category('day')
        ->value('value')
        ->toChart();

    expect($chart->toArray())->toEqual($this->expected);
});
