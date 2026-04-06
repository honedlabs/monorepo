<?php

declare(strict_types=1);

use Honed\Chart\Series\Pie;

beforeEach(function () {
    // option = {
    //     title: {
    //       text: 'Referer of a Website',
    //       subtext: 'Fake Data',
    //       left: 'center'
    //     },
    //     tooltip: {
    //       trigger: 'item'
    //     },
    //     legend: {
    //       orient: 'vertical',
    //       left: 'left'
    //     },
    //     series: [
    //       {
    //         name: 'Access From',
    //         type: 'pie',
    //         radius: '50%',
    //         data: [
    //           { value: 1048, name: 'Search Engine' },
    //           { value: 735, name: 'Direct' },
    //           { value: 580, name: 'Email' },
    //           { value: 484, name: 'Union Ads' },
    //           { value: 300, name: 'Video Ads' }
    //         ],
    //         emphasis: {
    //           itemStyle: {
    //             shadowBlur: 10,
    //             shadowOffsetX: 0,
    //             shadowColor: 'rgba(0, 0, 0, 0.5)'
    //           }
    //         }
    //       }
    //     ]
    //   };

    $this->values = [
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
    ];

    $this->option = [
        'title' => [
            'text' => 'Referer of a Website',
            'subtext' => 'Fake Data',
            'left' => 'center',
        ],
        'tooltip' => [
            'trigger' => 'item',
        ],
        'legend' => [
            'orient' => 'vertical',
            'left' => 'left',
        ],
        'series' => [
            [
                'name' => 'Access From',
                'type' => 'pie',
                'radius' => '50%',
                'data' => $this->values,
                'emphasis' => [
                    'itemStyle' => [
                        'shadowBlur' => 10,
                        'shadowOffsetX' => 0,
                        'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                    ],
                ],
            ],
        ],
    ];
})->skip();

it('creates', function () {
    $chart = Pie::make()
        ->from($this->data)
        ->on('value')
        ->showing('name')
        ->radius('50%', percentage: true)
        ->toChart()
        ->title->text('Referer of a Website')
        ->tooltip->triggerByItem()
        ->legend->vertical()
        ->legend->left('left');

    expect($chart->toArray())
        ->toEqualCanonicalizing($this->option);
});
