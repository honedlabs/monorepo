<?php

declare(strict_types=1);

use Honed\Chart\Emphasis;
use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('can have emphasis', function () {
    expect($this->series)
        ->getEmphasis()->toBeNull()
        ->emphasis()->toBe($this->series)
        ->getEmphasis()->toBeInstanceOf(Emphasis::class)
        ->emphasis(false)->toBe($this->series)
        ->getEmphasis()->toBeNull()
        ->emphasis(fn (Emphasis $e) => $e)->toBe($this->series)
        ->getEmphasis()->toBeInstanceOf(Emphasis::class)
        ->emphasis(null)->toBe($this->series)
        ->getEmphasis()->toBeNull()
        ->emphasis(Emphasis::make())->toBe($this->series)
        ->getEmphasis()->toBeInstanceOf(Emphasis::class);
});

it('includes emphasis in series payload when set', function () {
    $this->series->emphasis(fn (Emphasis $e) => $e->disabled()->label->show());

    $payload = $this->series->toArray();

    expect($payload)->toHaveKey('emphasis')
        ->and($payload['emphasis'])->toBeArray()
        ->and($payload['emphasis']['disabled'])->toBeTrue()
        ->and($payload['emphasis']['label'])->toBeArray();
});
