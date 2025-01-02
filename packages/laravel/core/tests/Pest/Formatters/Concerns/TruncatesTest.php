<?php

declare(strict_types=1);

use Honed\Core\Formatters\Concerns\Truncates;

class TruncatesComponent
{
    use Truncates;
}

beforeEach(function () {
    $this->component = new TruncatesComponent;
});

it('has no truncation by default', function () {
    expect($this->component)
        ->getTruncate()->toBeNull()
        ->hasTruncate()->toBeFalse();
});

it('sets truncation', function () {
    $this->component->setTruncate(100);
    expect($this->component)
        ->getTruncate()->toBe(100)
        ->hasTruncate()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setTruncate(100);
    $this->component->setTruncate(null);
    expect($this->component)
        ->getTruncate()->toBe(100)
        ->hasTruncate()->toBeTrue();
});

it('chains truncation', function () {
    expect($this->component->truncate(100))->toBeInstanceOf(TruncatesComponent::class)
        ->getTruncate()->toBe(100)
        ->hasTruncate()->toBeTrue();
});
