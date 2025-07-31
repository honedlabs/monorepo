<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Chart;
use Honed\Chart\Legend\Legend;
use Honed\Chart\Series\Line\Line;
use Honed\Chart\Title\Title;
use Honed\Chart\Tooltip\Tooltip;

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
            'name' => 'Search Engine'
        ],
        [
            'value' => 735,
            'name' => 'Direct'
        ],
        [
            'value' => 580,
            'name' => 'Email'
        ],
        [
            'value' => 484,
            'name' => 'Union Ads'
        ],
        [
            'value' => 300,
            'name' => 'Video Ads'
        ]
    ];

    $this->option = [
        'title' => [
            'text' => 'Referer of a Website',
            'subtext' => 'Fake Data',
            'left' => 'center'
        ],
        'tooltip' => [
            'trigger' => 'item'
        ],
        'legend' => [
            'orient' => 'vertical',
            'left' => 'left'
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
                        'shadowColor' => 'rgba(0, 0, 0, 0.5)'
                    ]
                ]
            ]
        ]
    ];
})->skip();

it('creates', function () {
    $chart = Chart::make()
        ->title(Title::make()
            ->text('Referer of a Website')
            ->subtext('Fake Data')
            ->left('center')
        )
        ->tooltip(Tooltip::make()
            ->triggerByItem()
        )
        ->legend(Legend::make()
            ->orient('vertical')
            ->left('left')
        )
        ->series(Pie::make()
            ->pluck('value')
            ->label('name')
            ->radius('50%')
            ->emphasis(Emphasis::make()
                ->itemStyle(ItemStyle::make()
                    ->shadowBlur(10)
                    ->shadowOffsetX(0)
                    ->shadowColor(Rgba::make(0, 0, 0, 0.5))
                )
            )
        );

    expect($chart->toArray())
        ->toEqualCanonicalizing($this->option);    
});