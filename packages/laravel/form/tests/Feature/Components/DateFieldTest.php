<?php

declare(strict_types=1);

use Honed\Form\Components\DateField;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Enums\Granularity;

beforeEach(function () {
    $this->component = DateField::make('start_at');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Date)
        ->getComponent()->toBe(FormComponent::Date->value);
});

it('has granularity attribute', function () {
    expect($this->component)
        ->getAttributes()->toBe([])
        ->granularity('day')->toBe($this->component)
        ->getAttributes()->toBe(['granularity' => 'day'])
        ->granularity(Granularity::Hour)->toBe($this->component)
        ->getAttributes()->toBe(['granularity' => 'hour']);
});

it('has locale attribute', function () {
    expect($this->component)
        ->getAttributes()->toBe([])
        ->locale('en')->toBe($this->component)
        ->getAttributes()->toBe(['locale' => 'en'])
        ->locale(Granularity::Second)->toBe($this->component)
        ->getAttributes()->toBe(['locale' => 'second']);
});

it('gets value', function (mixed $value, ?string $format) {
    expect($this->component->record([]))
        ->getValue()->toBe($value);
})->with([
    [null, null],
])->skip();