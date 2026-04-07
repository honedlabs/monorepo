<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Proxies\HigherOrderProxy;
use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->source = Chart::make();

    $this->tooltip = Tooltip::make();

    $this->proxy = new HigherOrderProxy($this->source, $this->tooltip);
});

it('forwards to proxy and returns source when fluent', function () {
    expect($this->proxy)
        ->triggerByAxis()->toBe($this->source);
});
