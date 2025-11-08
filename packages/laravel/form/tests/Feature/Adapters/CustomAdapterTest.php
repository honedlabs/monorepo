<?php

declare(strict_types=1);

use Honed\Form\Adapters\CustomAdapter;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Data;


beforeEach(function () {
    $this->adapter = app(CustomAdapter::class);
});

it('gets property component', function () {
    $dataClass = app(DataConfig::class)->getDataClass(Data::class);

    // expect($this->adapter)
    //     ->getPropertyComponent($property, $dataClass)->toBe(Input::class);
});