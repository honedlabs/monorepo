<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\Proxies\HigherOrderProxy;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('is proxyable', function () {
    expect($this->chart)
        ->__get('textStyle')->toBeInstanceOf(HigherOrderProxy::class);
});

it('protects properties', function () {
    $this->chart->tooltipInstance;
})->throws(ErrorException::class);

it('prevents undefined properties', function () {
    $this->chart->unknown;
})->throws(ErrorException::class);
