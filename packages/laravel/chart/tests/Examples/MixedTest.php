<?php

declare(strict_types=1);

use Honed\Chart\Axis;
use Honed\Chart\Chart;
use Honed\Chart\Series\Bar;
use Honed\Chart\Tooltip;
use Illuminate\Support\Arr;

beforeEach(function () {
    // https://echarts.apache.org/examples/en/editor.html?c=mix-line-bar
    
    $this->expected = [];

    $this->data = [];
});

it('is replicable', function () {

})->skip();
