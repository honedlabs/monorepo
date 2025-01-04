<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasLabel;

class HasLabelTest
{
    use Evaluable;
    use HasLabel;
}

beforeEach(function () {
    $this->test = new HasLabelTest;
});

it('has no label by default', function () {
    expect($this->test)
        ->getLabel()->toBeNull()
        ->hasLabel()->toBeFalse();
});

it('sets label', function () {
    $this->test->setLabel('Label');
    expect($this->test)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('rejects null values', function () {
    $this->test->setLabel('Label');
    $this->test->setLabel(null);
    expect($this->test)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('chains label', function () {
    expect($this->test->label('Label'))->toBeInstanceOf(HasLabelTest::class)
        ->getLabel()->toBe('Label')
        ->hasLabel()->toBeTrue();
});

it('resolves label', function () {
    expect($this->test->label(fn ($record) => $record.'.'))
        ->toBeInstanceOf(HasLabelTest::class)
        ->resolveLabel(['record' => 'Label'])->toBe('Label.')
        ->getLabel()->toBe('Label.');
});

it('makes a label', function () {
    expect($this->test->makeLabel('new-Label'))->toBe('New label');
});
