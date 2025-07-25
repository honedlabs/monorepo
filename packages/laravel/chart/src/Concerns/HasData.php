<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasSource
{
    XAxis::make()
        ->property('source');

    XAxis::make()
        ->call('method', 'parameters');

    XAxis::make()
        ->pluck('key');

    XAxis::make()
        ->source(fn ($src) => $source->pluck('s'));

    Axis::make()
        ->state(SomeEnum::class)
        ->state([1, 2, 3])

    Axis::make()
        ->type('value' | 'category')
        ->value()
        ->label()
        ->category()
        // ->boundaryGap()

    Legend::make()
        ->state('series')
        ->from('series');

    Tooltip::make()
        ->trigger('axis')
        ->trigger->axis();

    ->title('Some title')

    Toolbox::make()
        ->feature(Toolbox::dataZoom)
        ->feature(Toolbox::Save)

    Chart::make()
        ->series([
            Series::make()
                ->label('Video ads')
                ->state('value')
                ->type(Series::Line)
                ->smooth()->notSmooth(),

            LineSeries::make()
                ->label('Video ads')
                // ->stack()
                ->state('pluck'),

            LineSeries::make()
                ->state('pluck'),

            AreaSeries::make()
                // Equal to
                ->type('line')
                ->areaStyle([])

            BarSeries::make()
                ->barWidth('60%')
                ->showBackgroun()
                ->backgroundStyle([
                    'color' => 'rgba(180, 180, 180, 0.2)',
                ]),

            Pie::make()
                ->sort()
                ->data('column')
                ->labels('column')
                // ->itemStyle
                ->animationType
                ->animationEasing
                ->animationDelay
        ])
}