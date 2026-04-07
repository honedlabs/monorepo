<?php

declare(strict_types=1);

use Honed\Chart\Series\Bar;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->expected = [
        'tooltip' => [
            'trigger' => 'axis',
            // 'axisPointer' => [
            //     'type' => 'shadow',
            // ],
        ],
        'xAxis' => [
            [
                'type' => 'category',
                'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                // 'axisTick' => [
                //     'alignWithLabel' => true,
                // ],
            ],
        ],
        'yAxis' => [
            [
                'type' => 'value',
            ],
        ],
        'series' => [
            [
                'data' => [120, 200, 150, 80, 70, 110, 130],
                'type' => 'bar',
            ],
        ],
    ];

    $this->data = array_map(
        static fn ($day, $value) => [
            'day' => $day,
            'value' => $value,
        ],
        Arr::get($this->expected, 'xAxis.0.data'),
        Arr::get($this->expected, 'series.0.data')
    );
});

it('is replicable', function () {
    $chart = Bar::make()
        ->from($this->data)
        ->infer()
        ->category('day')
        ->value('value')
        ->toChart()
        ->tooltip->triggerByAxis();

    expect($chart->toArray())->toEqual($this->expected);
});
