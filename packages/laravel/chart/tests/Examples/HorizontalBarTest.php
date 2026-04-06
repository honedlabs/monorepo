<?php

declare(strict_types=1);

use Honed\Chart\Axis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Bar;
use Honed\Chart\Tooltip;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->expected = [
        'title' => [
            'text' => 'World Population',
        ],
        'tooltip' => [
            'trigger' => 'axis',
            // 'axisPointer' => [
            //     'type' => 'shadow',
            // ],
        ],
        'legend' => [],
        'xAxis' => [
            [
                'type' => 'value',
                // 'boundaryGap' => [0, 0.01],
            ],
        ],
        'yAxis' => [
            [
                'type' => 'category',
                'data' => ['Brazil', 'Indonesia', 'USA', 'India', 'China', 'World'],
            ],
        ],
        'series' => [
            [
                'name' => '2011',
                'type' => 'bar',
                'data' => [18203, 23489, 29034, 104970, 131744, 630230],
            ],
            [
                'name' => '2012',
                'type' => 'bar',
                'data' => [19325, 23438, 31000, 121594, 134141, 681807],
            ],
        ],
    ];

    $this->data = array_map(
        static fn (string $country, int $a, int $b): array => [
            'country' => $country,
            '2011' => $a,
            '2012' => $b,
        ],
        Arr::get($this->expected, 'yAxis.0.data'),
        Arr::get($this->expected, 'series.0.data'),
        Arr::get($this->expected, 'series.1.data')
    );
});

it('is replicable', function () {
    $chart = Chart::make()
        ->flip()
        ->from($this->data)
        ->infer()
        ->category('country')
        ->title('World Population')
        ->tooltip(fn (Tooltip $tooltip) => $tooltip->triggerByAxis())
        ->legend()
        // ->x(fn (Axis $axis) => $axis->boundaryGap(0, 0.01))
        ->series([
            Bar::make()
                ->name('2011')
                ->value('2011'),
            Bar::make()
                ->name('2012')
                ->value('2012'),
        ]);

    expect($chart->toArray())->toEqual($this->expected);
});
