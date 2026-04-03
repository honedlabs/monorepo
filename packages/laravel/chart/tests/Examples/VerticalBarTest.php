<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Chart;
use Honed\Chart\Enums\Trigger;
use Honed\Chart\Series\Bar;
use Honed\Chart\Tooltip\Tooltip;
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
                'name' => 'Direct',
                'type' => 'bar',
                'barWidth' => '60%',
                'data' => [10, 52, 200, 334, 390, 330, 220],
            ],
        ],
    ];

    $this->data = array_map(
        static fn (string $day, int|float $value): array => ['day' => $day, 'value' => $value],
        Arr::get($this->expected, 'xAxis.0.data'),
        Arr::get($this->expected, 'series.0.data')
    );
})->only();

it('is replicable', function () {
    $chart = Bar::make()
        ->from($this->data)
        ->infer()
        ->on('day')
        ->showing('value')
        ->width('60%')
        ->toChart()
        ->tooltip->trigger(Trigger::Axis);

    expect($chart->toArray())
        ->toEqualCanonicalizing($this->expected);
});