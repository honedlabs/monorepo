<?php

declare(strict_types=1);

use Carbon\Carbon;
use Honed\Form\Components\DateField;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Enums\Granularity;
use Honed\Form\Form;

beforeEach(function () {
    $this->freezeTime();

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

it('gets value', function ($value, $expected) {
    expect($this->component)
        ->form(Form::make()->record(['start_at' => $value]))
        ->getValue()->toBe($expected);
})->with([
    [null, null],
    fn () => ['2025-01-01', '2025-01-01'],
    function () {
        $this->component->format('Y-m-d H:i:s');

        return ['2025-01-01', '2025-01-01 00:00:00'];
    },
    function () {
        $this->component->format('Y-m-d');

        return [Carbon::parse('2025-01-01'), '2025-01-01'];
    },
]);
