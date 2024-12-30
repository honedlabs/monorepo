<?php

use Honed\Core\Formatters\StringFormatter;

beforeEach(function () {
    $this->formatter = StringFormatter::make();
});

it('has no prefix by default', function () {
    expect($this->formatter->hasPrefix())->toBeFalse();
});

it('can set a prefix', function () {
    expect($this->formatter->prefix('#'))->toBeInstanceOf(StringFormatter::class)
        ->getPrefix()->toBe('#');
});

it('can be set using setter', function () {
    $this->formatter->setPrefix('#');
    expect($this->formatter->getPrefix())->toBe('#');
});

it('does not accept null values', function () {
    $this->formatter->setPrefix('#');
    $this->formatter->setPrefix(null);
    expect($this->formatter->getPrefix())->toBe('#');
});
