<?php

declare(strict_types=1);

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Formatters\DefaultFormatter;
use Honed\Infolist\Formatters\NumericFormatter;
use Honed\Infolist\Formatters\TextFormatter;

beforeEach(function () {
    $this->entry = Entry::make('name');
});

it('has formatter', function () {
    expect($this->entry)
        ->getFormatter()->toBeInstanceOf(DefaultFormatter::class)
        ->format(5)->toBe(5)
        ->formatter(NumericFormatter::class)->toBe($this->entry)
        ->getFormatter()->toBeInstanceOf(NumericFormatter::class)
        ->format(5)->toBe('5')
        ->formatter(new TextFormatter())->toBe($this->entry)
        ->getFormatter()->toBeInstanceOf(TextFormatter::class)
        ->format(5)->toBe('5');
});
