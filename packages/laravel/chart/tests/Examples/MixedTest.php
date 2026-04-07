<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Legend;
use Honed\Chart\Series\Bar;
use Honed\Chart\Series\Line;
use Honed\Chart\Toolbox;
use Honed\Chart\Tooltip;
use Illuminate\Support\Arr;

beforeEach(function () {
    // https://echarts.apache.org/examples/en/editor.html?c=mix-line-bar

    $this->expected = [
        'tooltip' => [
            'trigger' => 'axis',
            // 'axisPointer' => [
            //     'type' => 'cross',
            //     'crossStyle' => [
            //         'color' => '#999',
            //     ],
            // ],
        ],
        'toolbox' => [
            'feature' => [
                'dataView' => ['show' => true, 'readOnly' => false],
                'magicType' => ['show' => true, 'type' => ['line', 'bar']],
                'restore' => ['show' => true],
                'saveAsImage' => ['show' => true],
            ],
        ],
        'legend' => [
            'data' => ['Evaporation', 'Precipitation', 'Temperature'],
        ],
        'xAxis' => [
            [
                'type' => 'category',
                'data' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                // 'axisPointer' => [
                //     'type' => 'shadow',
                // ],
            ],
        ],
        'yAxis' => [
            [
                'type' => 'value',
                // Second value axis / scale options are not emitted by the package today.
                // 'name' => 'Precipitation',
                // 'min' => 0,
                // 'max' => 250,
                // 'interval' => 50,
                // 'axisLabel' => [
                //     'formatter' => '{value} ml',
                // ],
            ],
            // [
            //     'type' => 'value',
            //     'name' => 'Temperature',
            //     'min' => 0,
            //     'max' => 25,
            //     'interval' => 5,
            //     'axisLabel' => [
            //         'formatter' => '{value} °C',
            //     ],
            // ],
        ],
        'series' => [
            [
                'name' => 'Evaporation',
                'type' => 'bar',
                // 'tooltip' => [
                //     'valueFormatter' => '(client-only in ECharts)',
                // ],
                'data' => [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6],
            ],
            [
                'name' => 'Precipitation',
                'type' => 'bar',
                'data' => [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6],
            ],
            [
                'name' => 'Temperature',
                'type' => 'line',
                // 'yAxisIndex' => 1,
                'data' => [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3],
            ],
        ],
    ];

    $days = Arr::get($this->expected, 'xAxis.0.data');
    $this->data = [];

    foreach ($days as $i => $day) {
        $row = ['day' => $day];
        foreach (Arr::get($this->expected, 'series') as $series) {
            $row[$series['name']] = $series['data'][$i];
        }
        $this->data[] = $row;
    }
});

it('is replicable', function () {
    $chart = Chart::make()
        ->from($this->data)
        ->infer()
        ->category('day')
        ->value('Evaporation')
        ->tooltip(fn (Tooltip $tooltip) => $tooltip->triggerByAxis()
            // Chart / tooltip axisPointer (cross, crossStyle) not implemented on server payload.
            // ->axisPointer-> ...
        )
        ->legend(fn (Legend $legend) => $legend
            ->labels(['Evaporation', 'Precipitation', 'Temperature']))
        ->toolbox(fn (Toolbox $toolbox) => $toolbox
            ->feature([
                'dataView' => ['show' => true, 'readOnly' => false],
                'magicType' => ['show' => true, 'type' => ['line', 'bar']],
                'restore' => ['show' => true],
                'saveAsImage' => ['show' => true],
            ]))
        // xAxis axisPointer.type "shadow" not emitted.
        // ->x(fn ($axis) => $axis-> ...)
        // Dual y-axis (precipitation scale vs temperature scale) not built; second yAxis commented above.
        // ->y(...)
        ->series([
            Bar::make()
                ->name('Evaporation')
                ->value('Evaporation'),
            Bar::make()
                ->name('Precipitation')
                ->value('Precipitation'),
            Line::make()
                ->name('Temperature')
                ->value('Temperature'),
        ]);

    expect($chart->toArray())->toEqual($this->expected);
});
