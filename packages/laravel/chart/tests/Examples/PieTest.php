<?php

declare(strict_types=1);

use Honed\Chart\Series\Pie;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->expected = [
        'title' => [
            'text' => 'Referer of a Website',
            // 'subtext' => 'Fake Data',
            // 'left' => 'center',
        ],
        'tooltip' => [
            'trigger' => 'item',
        ],
        // 'legend' => [
        //     'orient' => 'vertical',
        //     'left' => 'left',
        // ],
        'series' => [
            [
                'name' => 'Access From',
                'type' => 'pie',
                // 'radius' => '50%',
                'data' => [
                    [
                        'value' => 1048,
                        'name' => 'Search Engine',
                    ],
                    [
                        'value' => 735,
                        'name' => 'Direct',
                    ],
                    [
                        'value' => 580,
                        'name' => 'Email',
                    ],
                    [
                        'value' => 484,
                        'name' => 'Union Ads',
                    ],
                    [
                        'value' => 300,
                        'name' => 'Video Ads',
                    ],
                ],
                // 'emphasis' => [
                //     'itemStyle' => [
                //         'shadowBlur' => 10,
                //         'shadowOffsetX' => 0,
                //         'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                //     ],
                // ],
            ],
        ],
    ];

    $this->data = Arr::get($this->expected, 'series.0.data');
})->only();

it('creates', function () {
    $chart = Pie::make()
        ->name('Access From')
        ->from($this->data)
        ->value('value')
        ->category('name')
        // ->radius('50%', percentage: true)
        ->toChart()
        ->title('Referer of a Website')
        ->tooltip(fn ($tooltip) => $tooltip->triggerByItem());
    // ->tooltip->triggerByItem()
    // ->legend->vertical()
    // ->legend->left('left');

    expect($chart->toArray())
        ->toEqual($this->expected);
});
