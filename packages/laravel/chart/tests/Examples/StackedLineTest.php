<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Enums\AxisType;
use Honed\Chart\Grid;
use Honed\Chart\Series\Line;
use Honed\Chart\Toolbox;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->expected = [
        'title' => [
            'text' => 'Stacked Line',
        ],
        'tooltip' => [
            'trigger' => 'axis',
        ],
        'legend' => [
            'data' => ['Email', 'Union Ads', 'Video Ads', 'Direct', 'Search Engine'],
        ],
        'grid' => [
            'left' => '3%',
            'right' => '4%',
            'bottom' => '3%',
            'containLabel' => true,
        ],
        'toolbox' => [
            'feature' => [
                'saveAsImage' => [],
            ],
        ],
        'xAxis' => [
            [
                'type' => 'category',
                'boundaryGap' => false,
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
                'name' => 'Email',
                'type' => 'line',
                'stack' => 'Total',
                'data' => [120, 132, 101, 134, 90, 230, 210],
            ],
            [
                'name' => 'Union Ads',
                'type' => 'line',
                'stack' => 'Total',
                'data' => [220, 182, 191, 234, 290, 330, 310],
            ],
            [
                'name' => 'Video Ads',
                'type' => 'line',
                'stack' => 'Total',
                'data' => [150, 232, 201, 154, 190, 330, 410],
            ],
            [
                'name' => 'Direct',
                'type' => 'line',
                'stack' => 'Total',
                'data' => [320, 332, 301, 334, 390, 330, 320],
            ],
            [
                'name' => 'Search Engine',
                'type' => 'line',
                'stack' => 'Total',
                'data' => [820, 932, 901, 934, 1290, 1330, 1320],
            ],
        ],
    ];

    $this->labels = Arr::pluck(Arr::get($this->expected, 'series'), 'name');

    $this->data = array_map(
        static fn ($day, $email, $unionAds, $videoAds, $direct, $searchEngine) => [
            'day' => $day,
            'email' => $email,
            'union_ads' => $unionAds,
            'video_ads' => $videoAds,
            'direct' => $direct,
            'search_engine' => $searchEngine,
        ],
        Arr::get($this->expected, 'xAxis.0.data'),
        Arr::get($this->expected, 'series.0.data'),
        Arr::get($this->expected, 'series.1.data'),
        Arr::get($this->expected, 'series.2.data'),
        Arr::get($this->expected, 'series.3.data'),
        Arr::get($this->expected, 'series.4.data'),
    );
});

it('is replicable', function () {
    $chart = Chart::make()
        ->from($this->data)
        ->infer()
        ->category('day')
        ->title('Stacked Line')
        ->x->boundaryGap(false)
        ->y->type(AxisType::Value)
        ->tooltip->triggerByAxis()
        ->legend->labels($this->labels)
        ->grid(fn (Grid $grid) => $grid
            ->left('3%')
            ->right('4%')
            ->bottom('3%')
            ->containLabel()
        )
        ->toolbox(fn (Toolbox $toolbox) => $toolbox
            ->feature(['saveAsImage' => []]))
        ->series([
            Line::make()
                ->name('Email')
                ->stack('Total')
                ->value('email'),
            Line::make()
                ->name('Union Ads')
                ->stack('Total')
                ->value('union_ads'),
            Line::make()
                ->name('Video Ads')
                ->stack('Total')
                ->value('video_ads'),
            Line::make()
                ->name('Direct')
                ->stack('Total')
                ->value('direct'),
            Line::make()
                ->name('Search Engine')
                ->stack('Total')
                ->value('search_engine'),
        ]);

    expect($chart->toArray())->toEqual($this->expected);
});
