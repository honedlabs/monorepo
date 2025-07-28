<?php

declare(strict_types=1);

use Honed\Chart\Axis\XAxis;
use Honed\Chart\Axis\YAxis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Line\Line;

beforeEach(function () {
    // Data
});

it('has chart', function () {
    $chart = Chart::make()
        ->axes([XAxis::make(), YAxis::make()])
        ->series([
            Line::make('Name')->pluck('quantity')
        ])
        ->toolbox()
        ->legend()
        ->tooltip()
        ->colors();
});