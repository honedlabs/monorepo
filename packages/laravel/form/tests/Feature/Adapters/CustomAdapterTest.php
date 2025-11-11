<?php

declare(strict_types=1);

use Honed\Form\Adapters\CustomAdapter;
use Honed\Form\Attributes\Components\Component;
use Honed\Form\Components\Input;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\DataConfig;

beforeEach(function () {
    $this->adapter = app(CustomAdapter::class);
});

it('gets property component', function () {
    $data = new class() extends Data
    {
        #[Component(Input::class)]
        public string $name;
    };

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    $property = $dataClass->properties->first();

    expect($this->adapter)
        ->getPropertyComponent($property, $dataClass)->toBeInstanceOf(Input::class);
});

it('does not get property component', function () {
    $data = new class() extends Data
    {
        public string $name;
    };

    $dataClass = app(DataConfig::class)->getDataClass($data::class);

    $property = $dataClass->properties->first();

    expect($this->adapter)
        ->getPropertyComponent($property, $dataClass)->toBeNull();
});

it('does not get rules component', function () {
    expect($this->adapter)
        ->getRulesComponent('value', ['nullable', 'string'])->toBeNull();
});
